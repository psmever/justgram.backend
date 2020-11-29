import express, { Application } from 'express';
import { Logger } from '@src/common';
require('dotenv').config();

import { testRouter, testRouterRootName } from '@src/controller';
import { RestAfterMiddleware, RestBeforeAfterMiddleware, RestMiddleware } from '@src/middlewares';

function addRouters(app: Application): void {
    const baseApiRoute = '/api';
    const baseRouteVersion = '/v1';

    app.use(`${baseApiRoute}/${testRouterRootName}`, RestBeforeAfterMiddleware);

    // Test Controller
    app.use(`${baseApiRoute}/${testRouterRootName}`, RestMiddleware, testRouter);

    app.use(`${baseApiRoute}/${testRouterRootName}`, RestAfterMiddleware);
}

export function initServer(app: Application): void {
    addRouters(app);
    return;
}

export function startServer(app: Application): void {
    const port = process.env.PORT || 3000;
    const serverEnv = process.env.SERVER_ENV || 'NOT FOUND SERVER ENV';

    app.listen(port, () => Logger.info(`Express :: ${serverEnv} :: server is running on port ${port}`, null, true));
}
