/* eslint-disable max-len */
const ApiBaseMiddleware = async (req: any, res: any, next: any) => {
    console.log('ApiBaseMiddleware');


    next();
};

export default ApiBaseMiddleware;
