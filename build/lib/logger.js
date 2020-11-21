"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.logger = void 0;
const winston = require("winston");
const devTransport = new winston.transports.Console({
    format: winston.format.combine(winston.format.colorize(), winston.format.timestamp(), winston.format.json(), winston.format.printf((info) => {
        return `\u001B[34m[${info.timestamp}]\u001b[39m ${info.level}: ${info.message}`;
    })),
});
const prodTransport = new winston.transports.Console({
    format: winston.format.combine(winston.format.simple(), winston.format.printf((info) => {
        return `\u001b[39m ${info.level}: ${info.message}`;
    })),
});
const transports = [devTransport];
exports.logger = winston.createLogger({
    exitOnError: false,
    transports,
});
//# sourceMappingURL=logger.js.map