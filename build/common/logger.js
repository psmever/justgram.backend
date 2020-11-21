"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var winston_1 = require("winston");
var label = winston_1.format.label, combine = winston_1.format.combine, timestamp = winston_1.format.timestamp, prettyPrint = winston_1.format.prettyPrint;
var logger = winston_1.createLogger({
    format: combine(timestamp(), prettyPrint()),
    transports: [
        new winston_1.transports.Console(),
        new winston_1.transports.File({ filename: './error.log', level: 'error' }),
        new winston_1.transports.File({ filename: './info.log', level: 'info' }),
    ],
    exitOnError: false,
});
exports.default = logger;
//# sourceMappingURL=logger.js.map