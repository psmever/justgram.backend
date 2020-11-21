import * as express from 'express';
import { addRoutesAuth } from './routes/v1/Auth.routers';

const mainRouter = (_req: express.Request, res: express.Response) => {
    res.json({
        message: 'Welcome To JustGram Backend Server'
    });
}

const setupApp = (): express.Express => {
    const app = express();

    app.get('/', mainRouter);

    addRoutesAuth(app);

    return app;
}

export default setupApp;