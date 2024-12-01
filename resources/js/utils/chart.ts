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