import App from './App';
import config from './config';
import { logger } from './lib/logger';

const startServer = async () => {
    await connectDb();
    App().listen(config.PORT, () => {
        logger.info(`App ( ${config.NODE_ENV} ) is running at port: ${config.PORT}, hostname: ${config.HOSTNAME}`);
    });
}

const connectDb = async (): Promise<any> => {
    let db: any;

    return db;
}

startServer();