import { Application } from 'express';
import bodyParser from 'body-parser';
import cors from 'cors';
import passport from 'passport';
import { Logger } from '@common';
import dotenv from 'dotenv';
import Passport from '@src/middlewares/Passport';

dotenv.config();

import { RestAfterMiddleware, RestBeforeAfterMiddleware, RestMiddleware } from '@src/middlewares';
import { TestsRouter, SystemsRouter, AuthRouter } from '@src/routers';

function addRouters(app: Application): void {
    const baseApiRoute = '/api';
    // const baseRouteVersion = '/v1';

    app.use(`${baseApiRoute}`, RestBeforeAfterMiddleware);

    app.use(`${baseApiRoute}/tests`, RestMiddleware, TestsRouter);
    app.use(`${baseApiRoute}/systems`, RestMiddleware, SystemsRouter);
    app.use(`${baseApiRoute}/auth`, RestMiddleware, AuthRouter);

    app.use(`${baseApiRoute}`, RestAfterMiddleware);
}

export function initServer(app: Application): void {
    addRouters(app);

    app.use(bodyParser.json());
    app.use(bodyParser.urlencoded({ extended: true }));
    app.use(
        cors({
            origin: 'http://localhost',
        })
    );

    app.use(passport.initialize());

    Passport(passport);

    return;
}

export function startServer(app: Application): void {
    const port = process.env.PORT || 3000;
    const serverEnv = process.env.SERVER_ENV || 'NOT FOUND SERVER ENV';

    app.listen(port, () => Logger.info(`Express :: ${serverEnv} :: server is running on port ${port}`, null, true));
}
