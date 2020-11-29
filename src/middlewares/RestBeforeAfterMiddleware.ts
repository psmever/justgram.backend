import { Request, Response, NextFunction } from 'express';
import { isEmpty } from '@src/common';
import { ClientErrorResponse } from '@src/middlewares';

export const RestBeforeAfterMiddleware = async (req: Request, res: Response, next: NextFunction) => {
    res.setHeader('Content-Type', 'application/json; charset=utf-8');
    res.setHeader('Access-Control-Allow-Origin', '*');
    res.setHeader('Access-Control-Allow-Methods', 'DELETE,GET,PATCH,POST,PUT');
    res.setHeader('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization');

    // 클라이언트 타입 체크
    if (isEmpty(req.headers['request-client-type']) === true) {
        ClientErrorResponse(res, {
            error: 'not found client type',
            message: '알수 없는 클라이언트 입니다.'
        });
        return;
    }

    // accept 체크
    if (isEmpty(req.headers['accept']) === true) {
        ClientErrorResponse(res, {
            error: 'not found Accept type',
            message: 'Accept 타입이 존재 하지 않습니다.'
        });
        return;
    }

    // Content-type 체크
    if (isEmpty(req.headers['content-type']) === true) {
        ClientErrorResponse(res, {
            error: 'not found content type',
            message: 'Content Type 타입이 존재 하지 않습니다.'
        });
        return;
    }

    next();
};
