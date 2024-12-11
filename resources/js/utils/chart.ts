import moment from "moment";
import { subset } from "./data";
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

function calculateRoundedMaxValue(value: number): number {
    if (value <= 0) {
        throw new Error("Value must be greater than 0");
    }

    // Determine the order of magnitude of the value
    const orderOfMagnitude = Math.pow(10, Math.floor(Math.log10(value)));

    // Round up to the nearest significant digit
    const roundedValue = Math.ceil(value / orderOfMagnitude) * orderOfMagnitude;

    return roundedValue;
}

export const getYMax = (data: Array<number>) => {
    return calculateRoundedMaxValue(Math.max(...data));
};

/**
 * Calculates the cumulative sum of an array of numbers.
 *
 * @param data - An array of numbers to calculate the cumulative sum for.
 * @returns An array of numbers representing the cumulative sum at each index, rounded to 2 decimal places.
 */
export const getCumulativeData = (data: Array<number>) => {
    const result: Array<number> = [];
    let sum = 0;
    for (let i = 0; i < data.length; i++) {
        sum += Number(data[i]);
        result.push(roundToDecimalPlace(sum, 2));
    }
    return result;
};

export const addAll = (data: Array<number>) => {
    return data.reduce((acc, cur) => Number(acc) + Number(cur), 0);
};

export function getKpiCategory(resultPercentage: number, flexPercentage = 10) {
    // target will be 100%
    // if within 10% of the target, it will be considered as on target, return "success"
    // if below 10% of the target, it will be considered as below target, return "danger"
    // if above 10% of the target, it will be considered as above target, return "warning"
    const target = 100;
    const lowerBound = target - flexPercentage;
    const upperBound = target + flexPercentage;
    if (resultPercentage < lowerBound) {
        return "danger";
    } else if (resultPercentage > upperBound) {
        return "warning";
    }
    return "success";
}

interface RawDataItem {
    year: string;
    month: string;
    date: string; // e.g., "2024-01-01"
    pit: string;
    category: string;
    contractor: string;
    coal_actual_kt: string; // string representation of a number
    coal_plan_kt: string; // string representation of a number
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
    mthPlan: number;
    ytdPlan: number;
    ytdActual: number;
    ytdPlanDiff: number;
    yearPlan: number;
}

export function transformToToDateTableData(
    rawData: RawDataItem[],
    selectedDate: Date,
    attr: string,
    planAttr: string,
    actualAttr: string
): ProcessedDataItem[] {
    // If currentDate is not provided, get the latest date from the data
    if (!selectedDate) {
        const dates = rawData.map((item) => new Date(item.date));
        selectedDate = new Date(Math.max.apply(null, dates));
    }

    // Prepare a Map to store data per attribute type
    const attributeDataMap = new Map<string, any>();

    rawData.forEach((item) => {
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
                mthPlan: 0,
                ytdPlan: 0,
                ytdActual: 0,
                yearPlan: 0,
            });
        }

        const attributeData = attributeDataMap.get(attrValue);

        // Convert plan and actual to numbers
        const actualDataNode = parseFloat(item[actualAttr]) || 0;
        const planDataNode = parseFloat(item[planAttr]) || 0;

        // If the date matches currentDate, update todayPlan and todayActual
        if (isSameDate(dataDate, selectedDate)) {
            attributeData.todayPlan += planDataNode;
            attributeData.todayActual += actualDataNode;
        }

        // If the date is in the same month and year,
        // and before or equal to currentDate, update mtdPlan and mtdActual
        if (
            isSameMonthAndYear(dataDate, selectedDate) &&
            dataDate <= selectedDate
        ) {
            attributeData.mtdActual += actualDataNode;
            attributeData.mtdPlan += planDataNode;
        }

        // update the month plan
        if (isSameMonthAndYear(dataDate, selectedDate)) {
            attributeData.mthPlan += planDataNode;
        }

        // If the date is in the same year,
        // and before or equal to the currentDate, update ytdActual and ytdPlan
        if (isSameYear(dataDate, selectedDate) && dataDate <= selectedDate) {
            attributeData.ytdActual += actualDataNode;
            attributeData.ytdPlan += planDataNode;
        }

        // Update the year plan
        if (isSameYear(dataDate, selectedDate)) {
            attributeData.yearPlan += planDataNode;
        }
    });

    // Now compute the plan differences and prepare the result array
    const result: ProcessedDataItem[] = [];

    attributeDataMap.forEach((attrData) => {
        attrData.todayPlanDiff = calculateDiff(
            attrData.todayActual,
            attrData.todayPlan
        );
        attrData.mtdPlanDiff = calculateDiff(
            attrData.mtdActual,
            attrData.mtdPlan
        );
        attrData.ytdPlanDiff = calculateDiff(
            attrData.ytdActual,
            attrData.ytdPlan
        );

        result.push(attrData);
    });

    return result.map(roundProcessedDataItemNumbers);
}

interface ProcessedYieldDataItem {
    attr: string;
    todayInputPlan: number;
    todayOutputPlan: number;
    todayInputActual: number;
    todayOutputActual: number;
    mtdInputPlan: number;
    mtdOutputPlan: number;
    mtdInputActual: number;
    mtdOutputActual: number;
    mthInputPlan: number;
    mthOutputPlan: number;
    ytdInputPlan: number;
    ytdOutputPlan: number;
    ytdInputActual: number;
    ytdOutputActual: number;
    yearInputPlan: number;
    yearOutputPlan: number;
}

interface YieldDataItem {
    date: string;
    plant: string;
    plant_target: number;
    input_actual: number;
    input_target: number;
    output_actual: number;
    output_target: number;
}

export function transformToYieldTableData(
    rawData: YieldDataItem[],
    selectedDate: Date,
    attr: string,
    planAttr: string,
    actualAttr: string
): ProcessedYieldDataItem[] {
    // If currentDate is not provided, get the latest date from the data
    if (!selectedDate) {
        const dates = rawData.map((item) => new Date(item.date));
        selectedDate = new Date(Math.max.apply(null, dates));
    }

    // Prepare a Map to store data per attribute type
    const attributeDataMap = new Map<string, any>();

    rawData.forEach((item) => {
        const attrValue = item[attr];
        const dataDate = new Date(item.date);

        // Initialize data for contractor if not present
        if (!attributeDataMap.has(attrValue)) {
            attributeDataMap.set(attrValue, {
                attr: attrValue,
                todayInputPlan: 0,
                todayOutputPlan: 0,
                todayInputActual: 0,
                todayOutputActual: 0,
                mtdInputPlan: 0,
                mtdOutputPlan: 0,
                mtdInputActual: 0,
                mtdOutputActual: 0,
                mthInputPlan: 0,
                mthOutputPlan: 0,
                ytdInputPlan: 0,
                ytdOutputPlan: 0,
                ytdInputActual: 0,
                ytdOutputActual: 0,
                yearInputPlan: 0,
                yearOutputPlan: 0,
            });
        }

        const attributeData = attributeDataMap.get(attrValue);

        // Convert plan and actual to numbers
        const actualInputDataNode = item.input_actual;
        const planInputDataNode = item.input_target;
        const actualOutputDataNode = item.output_actual;
        const planOutputDataNode = item.output_target;

        // If the date matches currentDate, update todayPlan and todayActual
        if (isSameDate(dataDate, selectedDate)) {
            attributeData.todayInputPlan += planInputDataNode;
            attributeData.todayOutputPlan += planOutputDataNode;
            attributeData.todayInputActual += actualInputDataNode;
            attributeData.todayOutputActual += actualOutputDataNode;
        }

        // If the date is in the same month and year,
        // and before or equal to currentDate, update mtdPlan and mtdActual
        if (
            isSameMonthAndYear(dataDate, selectedDate) &&
            dataDate <= selectedDate
        ) {
            attributeData.mtdInputPlan += planInputDataNode;
            attributeData.mtdOutputPlan += planOutputDataNode;
            attributeData.mtdInputActual += actualInputDataNode;
            attributeData.mtdOutputActual += actualOutputDataNode;
        }

        // update the month plan
        if (isSameMonthAndYear(dataDate, selectedDate)) {
            attributeData.mthInputPlan += planInputDataNode;
            attributeData.mthOutputPlan += planOutputDataNode;
        }

        // If the date is in the same year,
        // and before or equal to the currentDate, update ytdActual and ytdPlan
        if (isSameYear(dataDate, selectedDate) && dataDate <= selectedDate) {
            attributeData.ytdInputPlan += planInputDataNode;
            attributeData.ytdOutputPlan += planOutputDataNode;
            attributeData.ytdInputActual += actualInputDataNode;
            attributeData.ytdOutputActual += actualOutputDataNode;
        }

        // Update the year plan
        if (isSameYear(dataDate, selectedDate)) {
            attributeData.yearInputPlan += planInputDataNode;
            attributeData.yearOutputPlan += planOutputDataNode;
        }
    });

    // Now compute the plan differences and prepare the result array
    const result: ProcessedYieldDataItem[] = [];

    attributeDataMap.forEach((attrData) => {
        result.push(attrData);
    });

    return result;
}

function calculateDiff(actual: number, plan: number): number {
    if (plan === 0) return 0;
    const diff = (actual / plan);
    return diff;
}

function roundProcessedDataItemNumbers(
    data: ProcessedDataItem
): ProcessedDataItem {
    return {
        ...data,
        todayPlan: roundToDecimalPlace(data.todayPlan, 2),
        todayActual: roundToDecimalPlace(data.todayActual, 2),
        mtdPlan: roundToDecimalPlace(data.mtdPlan, 2),
        mtdActual: roundToDecimalPlace(data.mtdActual, 2),
        mthPlan: roundToDecimalPlace(data.mthPlan, 2),
        ytdPlan: roundToDecimalPlace(data.ytdPlan, 2),
        ytdActual: roundToDecimalPlace(data.ytdActual, 2),
        yearPlan: roundToDecimalPlace(data.yearPlan, 2),
    };
}

// Similar to ProcessedDataItem, but with two attributes for grouping : primaryAttr and secondaryAttr
interface ProcessedNestedDataItem {
    primaryAttr: string;
    secondaryAttr: string;
    todayPlan: number;
    todayActual: number;
    todayPlanDiff: number;
    mtdPlan: number;
    mtdActual: number;
    mtdPlanDiff: number;
    mthPlan: number;
    ytdPlan: number;
    ytdActual: number;
    ytdPlanDiff: number;
    yearPlan: number;
}

/**
 * Transforms raw data into a nested table structure grouped by two attributes
 * `primary` and `secondary`, and computes aggregated plan and actual values
 * (e.g., today, month-to-date, year-to-date). This function is copied from the
 * original transformToDateTableData function and modified to accept two
 * attribute for grouping. Refactoring is needed to avoid code duplication.
 *
 * @param {RawDataItem[]} rawData - The array of raw data items to process.
 * @param {Date} currentDate - The current date used to calculate daily, monthly, and yearly metrics.
 * @param {string} primaryAttr - The primary attribute for grouping the data.
 * @param {string} secondaryAttr - The secondary attribute for grouping within the primary attribute.
 * @param {string} planAttr - The attribute name representing the planned value.
 * @param {string} actualAttr - The attribute name representing the actual value.
 *
 * @returns {ProcessedNestedDataItem[]} - An array of processed nested data items with
 * computed metrics for each primary and secondary grouping.
 * It computes the following metrics for each combination:
 * - `todayPlan` and `todayActual`: Aggregates data for the current date.
 * - `mtdPlan` and `mtdActual`: Aggregates data for the current month up to the current date.
 * - `ytdPlan` and `ytdActual`: Aggregates data for the current year up to the current date.
 * - `monthPlan`: Cumulative total plan value for the month.
 * - `yearPlan`: Cumulative total plan value for the year.
 * Additionally, the function calculates the differences between actual and planned values for each period (e.g., today, MTD, YTD).
 */
export function transformToNestedDateTableData(
    rawData: RawDataItem[],
    currentDate: Date,
    primaryAttr: string,
    secondaryAttr: string,
    planAttr: string,
    actualAttr: string
): ProcessedNestedDataItem[] {
    // If currentDate is not provided, get the latest date from the data
    if (!currentDate) {
        const dates = rawData.map((item) => new Date(item.date));
        currentDate = new Date(Math.max.apply(null, dates));
    }

    // Prepare a nested Map to store data per attribute type
    const attributeDataMap = new Map<string, Map<string, any>>();

    rawData.forEach((item) => {
        const primaryAttrValue = item[primaryAttr];
        const secondaryAttrValue = item[secondaryAttr];
        const dataDate = new Date(item.date);

        // Initialize nested Map for primary attribute if not present
        if (!attributeDataMap.has(primaryAttrValue)) {
            attributeDataMap.set(primaryAttrValue, new Map());
        }

        const secondaryMap = attributeDataMap.get(primaryAttrValue);

        // Initialize data for secondary attribute if not present
        if (!secondaryMap.has(secondaryAttrValue)) {
            secondaryMap.set(secondaryAttrValue, {
                primaryAttr: primaryAttrValue,
                secondaryAttr: secondaryAttrValue,
                todayPlan: 0,
                todayActual: 0,
                mtdPlan: 0,
                mtdActual: 0,
                mthPlan: 0,
                ytdPlan: 0,
                ytdActual: 0,
                yearPlan: 0,
            });
        }

        const attributeData = secondaryMap.get(secondaryAttrValue);

        // the rest of logic is similar to the transformToToDateTableData function
        // Convert plan and actual to numbers
        const actualDataNode = parseFloat(item[actualAttr]) || 0;
        const planDataNode = parseFloat(item[planAttr]) || 0;

        // If the date matches currentDate, update todayPlan and todayActual
        if (isSameDate(dataDate, currentDate)) {
            attributeData.todayPlan += planDataNode;
            attributeData.todayActual += actualDataNode;
        }

        // If the date is in the same month and year, and before or equal to currentDate, update mtdPlan and mtdActual
        if (
            isSameMonthAndYear(dataDate, currentDate) &&
            dataDate <= currentDate
        ) {
            attributeData.mtdPlan += planDataNode;
            attributeData.mtdActual += actualDataNode;
        }

        // If the date falls within the current month and year, update the monthly plan.
        // Since this is a monthly plan, it may contain future data for the month.
        if (isSameMonthAndYear(dataDate, currentDate)) {
            attributeData.mthPlan += planDataNode;
        }

        // If the date is in the same year, and before or equal to currentDate, update ytdPlan and ytdActual
        if (isSameYear(dataDate, currentDate) && dataDate <= currentDate) {
            attributeData.ytdPlan += planDataNode;
            attributeData.ytdActual += actualDataNode;
        }

        // Update the year plan
        if (isSameYear(dataDate, currentDate)) {
            attributeData.yearPlan += planDataNode;
        }
    });

    // Now compute the plan differences and prepare the result array
    const result: ProcessedNestedDataItem[] = [];

    attributeDataMap.forEach((secondaryMap) => {
        secondaryMap.forEach((attrData) => {
            attrData.todayPlanDiff = calculateDiff(
                attrData.todayActual,
                attrData.todayPlan
            );
            attrData.mtdPlanDiff = calculateDiff(
                attrData.mtdActual,
                attrData.mtdPlan
            );
            attrData.ytdPlanDiff = calculateDiff(
                attrData.ytdActual,
                attrData.ytdPlan
            );

            result.push(attrData);
        });
    });

    return result.map(roundProcessedNestedDataItemNumbers);
}

// similar to roundProcessedDataItemNumbers, but for nested data interface
function roundProcessedNestedDataItemNumbers(
    data: ProcessedNestedDataItem
): ProcessedNestedDataItem {
    return {
        ...data,
        todayPlan: roundToDecimalPlace(data.todayPlan, 2),
        todayActual: roundToDecimalPlace(data.todayActual, 2),
        mtdPlan: roundToDecimalPlace(data.mtdPlan, 2),
        mtdActual: roundToDecimalPlace(data.mtdActual, 2),
        mthPlan: roundToDecimalPlace(data.mthPlan, 2),
        ytdPlan: roundToDecimalPlace(data.ytdPlan, 2),
        ytdActual: roundToDecimalPlace(data.ytdActual, 2),
        yearPlan: roundToDecimalPlace(data.yearPlan, 2),
    };
}

interface DailyKpiDataItem {
    date: Date;
    actual: number;
    plan: number;
    diff: number;
}

interface MonthlyKpiDataItem {
    date: Date;
    actual: number;
    plan: number;
    diff: number;
}

interface KpiDataResult {
    daily: Array<DailyKpiDataItem>;
    monthly: Array<MonthlyKpiDataItem>;
}

// Convert the raw data to KPI data and group by date
export function convertToDailyKpiData(
    rawData: RawDataItem[]
): Array<DailyKpiDataItem> {
    const kpiDataMap = new Map<string, DailyKpiDataItem>();

    rawData.forEach((item) => {
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
    kpiDataMap.forEach((kpiData) => {
        kpiData.diff = calculateDiff(kpiData.actual, kpiData.plan);
    });

    return Array.from(kpiDataMap.values());
}

// Convert the raw data to KPI data and group by date
export function convertToKpiDataByAttr(
    rawData: Array<any>,
    planAttr: string,
    actualAttr: string,
    startDateString = "",
    endDateString = ""
): KpiDataResult {
    const dailyKpiDataMap = new Map<string, DailyKpiDataItem>();
    const monthlyKpiDataMap = new Map<string, DailyKpiDataItem>();

    rawData.forEach((item) => {
        const date = new Date(item.date);
        const dailyKey = moment(date).format("YYYY-MM-DD");
        const monthlyKey = moment(date).format("YYYY-MM");

        if (!dailyKpiDataMap.has(dailyKey)) {
            dailyKpiDataMap.set(dailyKey, {
                date,
                actual: 0,
                plan: 0,
                diff: 0,
            });
        }
        if (!monthlyKpiDataMap.has(monthlyKey)) {
            monthlyKpiDataMap.set(monthlyKey, {
                date,
                actual: 0,
                plan: 0,
                diff: 0,
            });
        }

        const dailyKpiData = dailyKpiDataMap.get(dailyKey);
        const monthlyKpiData = monthlyKpiDataMap.get(monthlyKey);

        // Convert actualDataNode and planDataNode to numbers
        const actualDataNode = parseFloat(item[actualAttr]) || 0;
        const planDataNode = parseFloat(item[planAttr]) || 0;

        dailyKpiData!.actual += actualDataNode;
        dailyKpiData!.plan += planDataNode;
        monthlyKpiData!.actual += actualDataNode;
        monthlyKpiData!.plan += planDataNode;
    });

    // Calculate the difference
    dailyKpiDataMap.forEach((kpiData) => {
        kpiData.diff = calculateDiff(kpiData.actual, kpiData.plan);
    });
    monthlyKpiDataMap.forEach((kpiData) => {
        kpiData.diff = calculateDiff(kpiData.actual, kpiData.plan);
    });

    const dailyData =
        startDateString && endDateString
            ? subset(
                  Array.from(dailyKpiDataMap.values() as any),
                  startDateString,
                  endDateString
              )
            : Array.from(dailyKpiDataMap.values());

    const monthlyData = Array.from(monthlyKpiDataMap.values());

    return {
        daily: dailyData as any,
        monthly: monthlyData,
    };
}

interface DailyYieldKpiDataItem {
    date: Date;
    inputActual: number;
    inputPlan: number;
    outputActual: number;
    outputPlan: number;
}

// Convert the raw data to Yield line graph group by date
export function convertToYieldKpiDataByAttr(
    rawData: Array<YieldDataItem>,
    startDateString = "",
    endDateString = ""
): KpiDataResult {
    const dailyKpiDataMap = new Map<string, DailyYieldKpiDataItem>();
    const monthlyKpiDataMap = new Map<string, DailyYieldKpiDataItem>();

    rawData.forEach((item) => {
        const date = new Date(item.date);
        const dailyKey = moment(date).format("YYYY-MM-DD");
        const monthlyKey = moment(date).format("YYYY-MM");

        if (!dailyKpiDataMap.has(dailyKey)) {
            dailyKpiDataMap.set(dailyKey, {
                date,
                inputActual: 0,
                inputPlan: 0,
                outputActual: 0,
                outputPlan: 0,
            });
        }
        if (!monthlyKpiDataMap.has(monthlyKey)) {
            monthlyKpiDataMap.set(monthlyKey, {
                date,
                inputActual: 0,
                inputPlan: 0,
                outputActual: 0,
                outputPlan: 0,
            });
        }

        const dailyKpiData = dailyKpiDataMap.get(dailyKey);
        const monthlyKpiData = monthlyKpiDataMap.get(monthlyKey);

        // Convert actualDataNode and planDataNode to numbers
        const actualInputDataNode = parseFloat(String(item.input_actual)) || 0;
        const planInputDataNode = parseFloat(String(item.input_target)) || 0;
        const actualOutputDataNode = parseFloat(String(item.output_actual)) || 0;
        const planOutputDataNode = parseFloat(String(item.output_target)) || 0;

        dailyKpiData!.inputActual += actualInputDataNode;
        dailyKpiData!.inputPlan += planInputDataNode;
        dailyKpiData!.outputActual += actualOutputDataNode;
        dailyKpiData!.outputPlan += planOutputDataNode;
        monthlyKpiData!.inputActual += actualInputDataNode;
        monthlyKpiData!.inputPlan += planInputDataNode;
        monthlyKpiData!.outputActual += actualOutputDataNode;
        monthlyKpiData!.outputPlan += planOutputDataNode;
    });

    const rawDailyData =
        startDateString && endDateString
            ? subset(
                  Array.from(dailyKpiDataMap.values()) as any,
                  startDateString,
                  endDateString
              )
            : Array.from(dailyKpiDataMap.values());

    const rawMonthlyData = Array.from(monthlyKpiDataMap.values());

    return {
        daily: rawDailyData as any,
        monthly: rawMonthlyData as any,
    };
}

interface MonthlyKpiDataItem {
    date: Date;
    actual: number;
    plan: number;
    diff: number;
}

// Convert the raw data to KPI data and group by date
export function convertToMonthlyKpiData(
    rawData: RawDataItem[]
): Array<MonthlyKpiDataItem> {
    const kpiDataMap = new Map<string, MonthlyKpiDataItem>();

    rawData.forEach((item) => {
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
    kpiDataMap.forEach((kpiData) => {
        kpiData.diff = calculateDiff(kpiData.actual, kpiData.plan);
    });

    return Array.from(kpiDataMap.values());
}

interface UtilizationDataItem {
    year: string;
    month: string;
    date: string;
    plant: string;
    pit: string;
    target_run_hrs: string;
    actual_run_hrs: string;
    actual_down_hrs: string;
    actual_standby_hrs: string;
    target_ma: string;
    actual_ma: string;
    target_uoa: string;
    actual_uoa: string;
}

interface ProcessedUtilizationDataItem {
    attr: string;
    todayTargetRunTime: number;
    todayActualRunTime: number;
    todayActualDownTime: number;
    todayActualStandByTime: number;
    mtdTargetRunTime: number;
    mtdActualRunTime: number;
    mtdActualDownTime: number;
    mtdActualStandByTime: number;
    ytdTargetRunTime: number;
    ytdActualRunTime: number;
    ytdActualDownTime: number;
    ytdActualStandByTime: number;
}

export function transformToToDateUtilizationTableData(
    rawData: UtilizationDataItem[],
    currentDate: Date,
    attr: string
): ProcessedUtilizationDataItem[] {
    // If currentDate is not provided, get the latest date from the data
    if (!currentDate) {
        const dates = rawData.map((item) => new Date(item.date));
        currentDate = new Date(Math.max.apply(null, dates));
    }

    // Prepare a Map to store data per attribute type
    const attributeDataMap = new Map<string, any>();

    rawData.forEach((item) => {
        const attrValue = item[attr];
        const dataDate = new Date(item.date);

        // Initialize data for contractor if not present
        if (!attributeDataMap.has(attrValue)) {
            attributeDataMap.set(attrValue, {
                attr: attrValue,
                todayTargetRunTime: 0,
                todayActualRunTime: 0,
                todayActualDownTime: 0,
                todayActualStandByTime: 0,
                mtdTargetRunTime: 0,
                mtdActualRunTime: 0,
                mtdActualDownTime: 0,
                mtdActualStandByTime: 0,
                ytdTargetRunTime: 0,
                ytdActualRunTime: 0,
                ytdActualDownTime: 0,
                ytdActualStandByTime: 0,
            });
        }

        const attributeData = attributeDataMap.get(attrValue);

        // Convert plan and actual to numbers
        const actualRunTime = parseFloat(item.actual_run_hrs) || 0;
        const targetRunTime = parseFloat(item.target_run_hrs) || 0;
        const actualDownTime = parseFloat(item.actual_down_hrs) || 0;
        const actualStandByTime = parseFloat(item.actual_standby_hrs) || 0;

        // If the date matches currentDate, update todayPlan and todayActual
        if (isSameDate(dataDate, currentDate)) {
            attributeData.todayTargetRunTime += targetRunTime;
            attributeData.todayActualRunTime += actualRunTime;
            attributeData.todayActualDownTime += actualDownTime;
            attributeData.todayActualStandByTime += actualStandByTime;
        }

        // If the date is in the same month and year, and before or equal to currentDate, update mtdPlan and mtdActual
        if (isSameMonthAndYear(dataDate, currentDate)) {
            if (dataDate <= currentDate) {
                attributeData.mtdActualRunTime += actualRunTime;
                attributeData.mtdActualDownTime += actualDownTime;
                attributeData.mtdActualStandByTime += actualStandByTime;
                attributeData.mtdTargetRunTime += targetRunTime;
            }
            
        }

        // If the date is in the same year, and before or equal to currentDate, update ytdPlan and ytdActual
        if (isSameYear(dataDate, currentDate)) {
            if (dataDate <= currentDate) {
                attributeData.ytdTargetRunTime += targetRunTime;
                attributeData.ytdActualRunTime += actualRunTime;
                attributeData.ytdActualDownTime += actualDownTime;
                attributeData.ytdActualStandByTime += actualStandByTime;
            }

            
        }
    });

    // Now compute the plan differences and prepare the result array
    const result: ProcessedUtilizationDataItem[] = [];

    attributeDataMap.forEach((attrData) => {
        result.push(attrData);
    });

    return result;
}

export function getUOATableBgCellClass(
    value: number,
    successBound: number,
    warningBound: number
) {
    if (value >= successBound) {
        return "bg-success";
    } else if (value >= warningBound) {
        return "bg-warning";
    }
    return "bg-danger";
}
