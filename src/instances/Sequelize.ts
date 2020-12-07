import { Sequelize } from 'sequelize';
import dotenv from 'dotenv';
dotenv.config();

const config = {
    username: process.env.MYSQL_USERNAME ? process.env.MYSQL_USERNAME : '',
    password: process.env.MYSQL_PASSWORD ? process.env.MYSQL_PASSWORD : '',
    database: process.env.MYSQL_DATABASE ? process.env.MYSQL_DATABASE : '',
    host: process.env.MYSQL_HOST ? process.env.MYSQL_HOST : 'localhost',
    dialect: 'mariadb',
    port: process.env.MYSQL_PORT ? Number(process.env.MYSQL_PORT) : 3306,
};

/**
 * https://sequelize.org/master
 */
export const sequelize = new Sequelize(config.database, config.username, config.password, {
    host: config.host,
    dialect: 'mariadb',
    port: config.port,
});

sequelize.authenticate().then(
    function() {
        console.log('DB connection sucessful.');
    },
    function(err) {
        // catch error here
        console.log(err);
    }
);
