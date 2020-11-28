import express, { Application } from 'express';
import { Logger } from '@src/common';
require('dotenv').config();

import { testRouter, testRouterRootName } from '@src/controller';
import { RestMiddleware } from '@src/middlewares';
function addRouters(app: Application): void {
    /**
     * /api/v1/test/default
     */

    const baseRoute = '/api';
    const baseRouteVersion = '/v1';

    app.use(`${baseRoute}/${testRouterRootName}`, RestMiddleware, testRouter);
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
