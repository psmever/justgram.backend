import * as express from 'express';
import TestRoute from './routes/TestRoute';

import authRoute from './routes/v1/AuthRoute';


const mainRouter = (_req: express.Request, res: express.Response) => {
    res.json({
        message: 'Welcome To JustGram Backend Server'
    });
}

const setupApp = (): express.Express => {
    const app = express();

    app.get('/', mainRouter);

    app.use('/api/test', TestRoute);
    app.use('/api/v1/auth', authRoute);

    return app;
}

export default setupApp;