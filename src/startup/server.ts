import { Application } from 'express';
import { Logger } from '@common';
require('dotenv').config();

import { RestAfterMiddleware, RestBeforeAfterMiddleware, RestMiddleware } from '@src/middlewares';
import { TestsRouter, SystemsRouter } from '@src/routers';

function addRouters(app: Application): void {
    const baseApiRoute = '/api';
    // const baseRouteVersion = '/v1';

    app.use(`${baseApiRoute}`, RestBeforeAfterMiddleware);

    app.use(`${baseApiRoute}/tests`, RestMiddleware, TestsRouter);
    app.use(`${baseApiRoute}/systems`, RestMiddleware, SystemsRouter);

    // app.use(`${baseApiRoute}`, RestAfterMiddleware);
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
