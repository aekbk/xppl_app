export function roundToDecimalPlace(value: number, decimalPlaces: number = 2): number {
  const factor = Math.pow(10, decimalPlaces);
  return Math.round(value * factor) / factor;
}

export function average(numbers: Array<number>): number {
  return roundToDecimalPlace(numbers.reduce((sum, number) => sum + number, 0) / numbers.length, 2);
}

export function numberOrNull(value: any): number | null {
  return Number.isNaN(value) ? null : value;
}