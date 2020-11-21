"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.logger = void 0;
var winston = require("winston");
var devTransport = new winston.transports.Console({
    format: winston.format.combine(winston.format.colorize(), winston.format.timestamp(), winston.format.json(), winston.format.printf(function (info) {
        return "\u001B[34m[" + info.timestamp + "]\u001B[39m " + info.level + ": " + info.message;
    })),
});
var prodTransport = new winston.transports.Console({
    format: winston.format.combine(winston.format.simple(), winston.format.printf(function (info) {
        return "\u001B[39m " + info.level + ": " + info.message;
    })),
});
var transports = [devTransport];
exports.logger = winston.createLogger({
    exitOnError: false,
    transports: transports,
});
// Example logger function
// logger.info(`Message info`);
// logger.warn(`Message warn`);
// logger.error(`Message error`);
//# sourceMappingURL=logger.js.map