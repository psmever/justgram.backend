import * as express from 'express';
import { getTest } from '@src/controllers/v1/Auth.controller';

export const addRoutesAuth = (app: express.Application) => {
    app.get('/test', getTest);
}