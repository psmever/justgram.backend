"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.customLogger = void 0;
var winston_1 = require("winston");
// 직접 정의한 로그 레벨
var customLevels = {
    customedError: 0,
    customedWarn: 1,
    customedInfo: 2,
    customedDebug: 3,
    customedSilly: 4
};
// 레벨별 색상 * 주어지지않은 색상을 넣을 경우 오류 발생
var customColors = {
    customedError: 'red',
    customedWarn: 'yellow',
    customedInfo: 'cyan',
    customedDebug: 'magenta',
    customedSilly: 'gray'
};
// 색상을 추가하고싶다면 winston에게 이를 알려야한다. (README 참고)
winston_1.default.addColors(customColors);
exports.customLogger = winston_1.createLogger({
    levels: customLevels,
    format: winston_1.format.combine(winston_1.format.label({ label: '[customed-server]' }), winston_1.format.timestamp({
        format: 'YYYY-MM-DD HH:mm:ss'
    }), winston_1.format.colorize(), // 색상을 보고싶다면 꼭 추가!
    winston_1.format.printf(function (info) { return info.timestamp + " - " + info.level + ": " + info.label + " " + info.message; })),
    transports: [
        new winston_1.transports.Console({ level: 'customedSilly' })
    ]
});
//# sourceMappingURL=logger.js.map