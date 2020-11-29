/* eslint-disable @typescript-eslint/no-explicit-any*/
const isEmpty = function(value: any) {
    if (
        value === '' ||
        value === null ||
        value === undefined ||
        (value !== null && typeof value === 'object' && !Object.keys(value).length)
    ) {
        return true;
    } else {
        return false;
    }
};
export { isEmpty };
