import express, { Application } from 'express';
import * as startup from './startup';

const app: Application = express();

startup.initServer(app);
startup.startServer(app);
