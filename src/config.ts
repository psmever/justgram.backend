import * as dotenv from "dotenv";
import * as path from "path";

export enum INodeEnv {
    "local" = "local",
    "dev" = "dev",
    "prod" = "prod",
    "test" = "test"
}

dotenv.config({
	path: path.join(path.dirname(__filename), "../.env")
});

export default {
	PORT: process.env.PORT,
	NODE_ENV: process.env.NODE_ENV,
	HOSTNAME: process.env.HOSTNAME,
	DB_CONNECTION: process.env.DB_CONNECTION,
	DB_CONNECTION_FOR_TESTS: process.env.DB_CONNECTION_FOR_TESTS
};