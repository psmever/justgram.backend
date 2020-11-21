import * as express from 'express';
import {logger} from 'src/lib/logger';

import TestRoute from './routes/TestRoute';
import authRoute from './routes/v1/AuthRoute';


const mainRouter = (_req: express.Request, res: express.Response) => {
    res.json({
        message: 'Welcome To JustGram Backend Server'
    });
}

const setupApp = (): express.Express => {
    const app = express();
    app.use((req, res, next) => {
        // console.log(res)
        next();
    });

    app.get('/', mainRouter);

    app.use('/api/test', TestRoute);
    app.use('/api/v1/auth', authRoute);

    return app;
}

export default setupApp;