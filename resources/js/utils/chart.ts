import { isSameDate, isSameMonthAndYear, isSameYear } from "./date";
import { roundToDecimalPlace } from "./number";

function getDivider(number: number): number {
  let absNumber = Math.abs(number); // Handle negative numbers

  if (absNumber === 0) return 1; // Edge case: if the number is 0, return 1

  let divider = 1;
  while (absNumber >= 10) {
      absNumber = Math.floor(absNumber / 10); // Reduce the number
      divider *= 10; // Increase the divider
  }

  return divider;
}

export const getStepSize = (data: Array<number>, step = 10) => {
  const max = Math.max(...data);

  const divider = getDivider(max);
  const maxRounded = Math.ceil(max / divider) * divider;
  const stepSize = maxRounded / step;
  console.log('stepSize', stepSize);
  return stepSize;
}

function calculateYAxisMax(maxValue: number, ticks: number = 10): { maxY: number; step: number } {
  // Ensure ticks is at least 1 to avoid division by zero
  ticks = Math.max(ticks, 1);

  // Calculate the rough step size
  const roughStep = maxValue / ticks;

  // Determine the magnitude of the rough step size
  const magnitude = Math.pow(10, Math.floor(Math.log10(roughStep)));

  // Normalize the step to the closest multiple of 0.1, 1, 2, 5, or 10
  let normalizedStep;
  if (roughStep / magnitude <= 0.1) {
      normalizedStep = 0.1;
  } else if (roughStep / magnitude <= 1) {
      normalizedStep = 1;
  } else if (roughStep / magnitude <= 2) {
      normalizedStep = 2;
  } else if (roughStep / magnitude <= 5) {
      normalizedStep = 5;
  } else {
      normalizedStep = 10;
  }

  // Scale the normalized step back to its original magnitude
  const step = normalizedStep * magnitude;

  // Calculate the maximum Y-axis value
  const maxY = Math.ceil(maxValue / step) * step;

  return { maxY, step };
}

export const getYMax = (data: Array<number>, step = 10) => {
  const stepSize = getStepSize(data, step);
  const calculatedYAxis = calculateYAxisMax(Math.max(...data), stepSize);
  console.log('calculatedYAxis', calculatedYAxis);
  return calculatedYAxis.maxY;
}


// Receive Kt and return Mt
export const getCumulativeData = (data: Array<number>) => {
  const result: Array<number> = [];
  let sum = 0;
  for (let i = 0; i < data.length; i++) {
    sum += Number(data[i]);
    result.push(Math.round(sum/1000 * 100) / 100);
  }
  return result;
}

export const addAll = (data: Array<number>) => {
  return data.reduce((acc, cur) => Number(acc) + Number(cur), 0);
}


export function getKpiCategory(resultPercentage: number, flexPercentage = 10) {
  // target will be 100%
  // if within 10% of the target, it will be considered as on target, return "success"
  // if below 10% of the target, it will be considered as below target, return "danger"
  // if above 10% of the target, it will be considered as above target, return "warning"
  const target = 100;
  const lowerBound = target - flexPercentage;
  const upperBound = target + flexPercentage;
  if (resultPercentage < lowerBound) {
    return 'danger';
  } else if (resultPercentage > upperBound) {
    return 'warning';
  }
  return 'success';
}

interface RawDataItem {
  year: string;
  month: string;
  date: string; // e.g., "2024-01-01"
  pit: string;
  category: string;
  contractor: string;
  coal_actual_kt: string; // string representation of a number
  coal_plan_kt: string;   // string representation of a number
  truck_count: string;
}

interface ProcessedDataItem {
  attr: string;
  todayPlan: number;
  todayActual: number;
  todayPlanDiff: number;
  mtdPlan: number;
  mtdActual: number;
  mtdPlanDiff: number;
  ytdPlan: number;
  ytdActual: number;
  ytdPlanDiff: number;
  totalPlan: number;
} 

export function transformToToDateTableData(rawData: RawDataItem[], currentDate: Date, attr: string, planAttr: string, actualAttr: string): ProcessedDataItem[] {
  // If currentDate is not provided, get the latest date from the data
  if (!currentDate) {
    const dates = rawData.map(item => new Date(item.date));
    currentDate = new Date(Math.max.apply(null, dates));
  }

  // Prepare a Map to store data per attribute type
  const attributeDataMap = new Map<string, any>();

  rawData.forEach(item => {
    const attrValue = item[attr];
    const dataDate = new Date(item.date);

    // Initialize data for contractor if not present
    if (!attributeDataMap.has(attrValue)) {
      attributeDataMap.set(attrValue, {
        attr: attrValue,
        todayPlan: 0,
        todayActual: 0,
        mtdPlan: 0,
        mtdActual: 0,
        ytdPlan: 0,
        ytdActual: 0,
        totalPlan: 0,
      });
    }

    const attributeData = attributeDataMap.get(attrValue);

    // Convert plan and actual to numbers
    const actualDataNode = parseFloat(item[actualAttr]) || 0;
    const planDataNode = parseFloat(item[planAttr]) || 0;

    // Update totalPlan
    attributeData.totalPlan += planDataNode;

    // If the date matches currentDate, update todayPlan and todayActual
    if (isSameDate(dataDate, currentDate)) {
      attributeData.todayPlan += planDataNode;
      attributeData.todayActual += actualDataNode;
    }

    // If the date is in the same month and year, and before or equal to currentDate, update mtdPlan and mtdActual
    if (isSameMonthAndYear(dataDate, currentDate) && dataDate <= currentDate) {
      attributeData.mtdPlan += planDataNode;
      attributeData.mtdActual += actualDataNode;
    }

    // If the date is in the same year, and before or equal to currentDate, update ytdPlan and ytdActual
    if (isSameYear(dataDate, currentDate) && dataDate <= currentDate) {
      attributeData.ytdPlan += planDataNode;
      attributeData.ytdActual += actualDataNode;
    }
  });

  // Now compute the plan differences and prepare the result array
  const result: ProcessedDataItem[] = [];

  attributeDataMap.forEach(attrData => {
    attrData.todayPlanDiff = calculateDiff(attrData.todayActual, attrData.todayPlan);
    attrData.mtdPlanDiff = calculateDiff(attrData.mtdActual, attrData.mtdPlan);
    attrData.ytdPlanDiff = calculateDiff(attrData.ytdActual, attrData.ytdPlan);

    result.push(attrData);
  });

  return result.map(roundProcessedDataItemNumbers);
}

function calculateDiff(actual: number, plan: number): number {
  if (plan === 0) return 0;
  const diff = (actual / plan) * 100;
  return diff;
}

function roundProcessedDataItemNumbers(data: ProcessedDataItem): ProcessedDataItem {
  return {
    ...data,
    todayPlan: roundToDecimalPlace(data.todayPlan, 2),
    todayActual: roundToDecimalPlace(data.todayActual, 2),
    mtdPlan: roundToDecimalPlace(data.mtdPlan, 2),
    mtdActual: roundToDecimalPlace(data.mtdActual, 2),
    ytdPlan: roundToDecimalPlace(data.ytdPlan, 2),
    ytdActual: roundToDecimalPlace(data.ytdActual, 2),
    totalPlan: roundToDecimalPlace(data.totalPlan, 2),
  };
}

interface DailyKpiDataItem {
  date: Date;
  actual: number;
  plan: number;
  diff: number;
}

// Convert the raw data to KPI data and group by date
export function convertToDailyKpiData(rawData: RawDataItem[]): Array<DailyKpiDataItem> {
  const kpiDataMap = new Map<string, DailyKpiDataItem>();

  rawData.forEach(item => {
    const date = new Date(item.date);
    const key = date.toISOString();

    if (!kpiDataMap.has(key)) {
      kpiDataMap.set(key, {
        date,
        actual: 0,
        plan: 0,
        diff: 0,
      });
    }

    const kpiData = kpiDataMap.get(key);

    // Convert coal_actual_kt and coal_plan_kt to numbers
    const coal_actual_kt = parseFloat(item.coal_actual_kt) || 0;
    const coal_plan_kt = parseFloat(item.coal_plan_kt) || 0;

    kpiData!.actual += coal_actual_kt;
    kpiData!.plan += coal_plan_kt;
  });

  // Calculate the difference
  kpiDataMap.forEach(kpiData => {
    kpiData.diff = calculateDiff(kpiData.actual, kpiData.plan);
  });

  return Array.from(kpiDataMap.values());
}

// Convert the raw data to KPI data and group by date
export function convertToDailyKpiDataByAttr(rawData: Array<any>, planAttr: string, actualAttr: string): Array<DailyKpiDataItem> {
  const kpiDataMap = new Map<string, DailyKpiDataItem>();

  rawData.forEach(item => {
    const date = new Date(item.date);
    const key = date.toISOString();

    if (!kpiDataMap.has(key)) {
      kpiDataMap.set(key, {
        date,
        actual: 0,
        plan: 0,
        diff: 0,
      });
    }

    const kpiData = kpiDataMap.get(key);

    // Convert actualDataNode and coal_plan_kt to numbers
    const actualDataNode = parseFloat(item[actualAttr]) || 0;
    const planDataNode = parseFloat(item[planAttr]) || 0;

    kpiData!.actual += actualDataNode;
    kpiData!.plan += planDataNode;
  });

  // Calculate the difference
  kpiDataMap.forEach(kpiData => {
    kpiData.diff = calculateDiff(kpiData.actual, kpiData.plan);
  });

  return Array.from(kpiDataMap.values());
}

interface MonthlyKpiDataItem {
  date: Date;
  actual: number;
  plan: number;
  diff: number;
}

// Convert the raw data to KPI data and group by date
export function convertToMonthlyKpiData(rawData: RawDataItem[]): Array<MonthlyKpiDataItem> {
  const kpiDataMap = new Map<string, MonthlyKpiDataItem>();

  rawData.forEach(item => {
    const date = new Date(item.date);
    const key = `${date.getFullYear()}-${date.getMonth()}`;

    if (!kpiDataMap.has(key)) {
      kpiDataMap.set(key, {
        date,
        actual: 0,
        plan: 0,
        diff: 0,
      });
    }

    const kpiData = kpiDataMap.get(key);

    // Convert coal_actual_kt and coal_plan_kt to numbers
    const coal_actual_kt = parseFloat(item.coal_actual_kt) || 0;
    const coal_plan_kt = parseFloat(item.coal_plan_kt) || 0;

    kpiData!.actual += coal_actual_kt;
    kpiData!.plan += coal_plan_kt;
  });

  // Calculate the difference
  kpiDataMap.forEach(kpiData => {
    kpiData.diff = calculateDiff(kpiData.actual, kpiData.plan);
  });

  return Array.from(kpiDataMap.values());
}