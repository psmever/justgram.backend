import express, { Application } from 'express';
import bodyParser from 'body-parser';
import cors from 'cors';
import passport from 'passport';
import { Logger } from '@common';
import dotenv from 'dotenv';
import Passport from '@src/middlewares/Passport';
import path from 'path';

dotenv.config();

import { RestAfterMiddleware, RestBeforeAfterMiddleware, RestMiddleware } from '@src/middlewares';
import { TestsRouter, SystemsRouter, AuthRouter, DefaultRouter } from '@src/routers';

function addRouters(app: Application): void {
    const baseApiRoute = '/api';
    const baseWebRoute = '/web';
    // const baseRouteVersion = '/v1';

    app.use(`${baseApiRoute}`, RestBeforeAfterMiddleware);

    app.use(`${baseApiRoute}/tests`, RestMiddleware, TestsRouter);
    app.use(`${baseApiRoute}/systems`, RestMiddleware, SystemsRouter);
    app.use(`${baseApiRoute}/auth`, RestMiddleware, AuthRouter);

    app.use(`${baseApiRoute}`, RestAfterMiddleware);

    app.use(`${baseWebRoute}`, DefaultRouter);
}

export function initServer(app: Application): void {
    app.engine('pug', require('pug').__express);
    app.set('views', path.join(__dirname, 'resources/views'));
    app.set('view engine', 'pug');
    app.use(express.static(path.join(__dirname, 'resources')));

    app.use(bodyParser.json());
    app.use(bodyParser.urlencoded({ extended: true }));
    app.use(
        cors({
            origin: 'http://localhost',
        })
    );

    app.use(passport.initialize());

    Passport(passport);

    addRouters(app);
    return;
}

export function startServer(app: Application): void {
    const port = process.env.PORT || 3000;
    const appName = process.env.APP_NAME || `NOT FOUND APP NAME`;
    const appEnv = process.env.APP_ENV || `NOT FOUND APP ENV`;

    app.listen(port, () => Logger.info(`\nExpress :: ${appEnv} ${appName} :: running on port ${port}\n`, null, true));
}
