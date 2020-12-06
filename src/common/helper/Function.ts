/* eslint-disable @typescript-eslint/no-explicit-any*/
const isEmpty = function(value: any): boolean {
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

// https://gist.github.com/ahtcx/0cd94e62691f539160b32ecda18af3d6
// deep-merge.js
const DeepMerge = (target: any, source: any): any => {
    // Iterate through `source` properties and if an `Object` set property to merge of `target` and `source` properties
    for (const key of Object.keys(source)) {
        if (source[key] instanceof Object) Object.assign(source[key], DeepMerge(target[key], source[key]));
    }

    // Join `target` and modified `source`
    Object.assign(target || {}, source);
    return target;
};

export { isEmpty, DeepMerge };
