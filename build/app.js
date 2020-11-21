"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var express = require("express");
var logger_1 = require("common/logger");
var app = express();
app.get("/", function (req, res, next) {
    logger_1.default.log({ message: 'Request recieved', level: 'info',
        transationId: 'one', correlationId: 'one',
        request: req.query,
        operation: 'demoFunction' });
    res.json({
        test: "hello typescript express!!!!!"
    });
});
exports.default = app;
//# sourceMappingURL=app.js.map