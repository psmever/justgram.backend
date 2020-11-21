import * as express from "express";
import { logger } from './lib/logger';

const app: express.Application = express();

app.get("/",(req: express.Request, res: express.Response, next: express.NextFunction) => {

    logger.info(`App is running at port: 3000`);

    res.json({
        test: "hello typescript express!!!!!"
    });
});

export default app;