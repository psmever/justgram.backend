"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.logger = void 0;
var winston_1 = require("winston");
var winston_daily_rotate_file_1 = require("winston-daily-rotate-file");
var logDir = 'logs'; // logs 디렉토리 하위에 로그 파일 저장
var _a = winston_1.default.format, combine = _a.combine, timestamp = _a.timestamp, printf = _a.printf;
// Define log format
var logFormat = printf(function (info) {
    return info.timestamp + " " + info.level + ": " + info.message;
});
/*
 * Log Level
 * error: 0, warn: 1, info: 2, http: 3, verbose: 4, debug: 5, silly: 6
 */
var logger = winston_1.default.createLogger({
    format: combine(timestamp({
        format: 'YYYY-MM-DD HH:mm:ss',
    }), logFormat),
    transports: [
        // info 레벨 로그를 저장할 파일 설정
        new winston_daily_rotate_file_1.default({
            level: 'info',
            datePattern: 'YYYY-MM-DD',
            dirname: logDir,
            filename: "%DATE%.log",
            maxFiles: 30,
            zippedArchive: true,
        }),
        // error 레벨 로그를 저장할 파일 설정
        new winston_daily_rotate_file_1.default({
            level: 'error',
            datePattern: 'YYYY-MM-DD',
            dirname: logDir + '/error',
            filename: "%DATE%.error.log",
            maxFiles: 30,
            zippedArchive: true,
        }),
    ],
});
exports.logger = logger;
// Production 환경이 아닌 경우(dev 등)
if (process.env.NODE_ENV !== 'production') {
    logger.add(new winston_1.default.transports.Console({
        format: winston_1.default.format.combine(winston_1.default.format.colorize(), // 색깔 넣어서 출력
        winston_1.default.format.simple())
    }));
}
//# sourceMappingURL=winston.js.map