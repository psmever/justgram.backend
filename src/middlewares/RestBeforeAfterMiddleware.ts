import { Request, Response, NextFunction } from 'express';
import { isEmpty } from '@common';
import { clientErrorResponse } from '@common';

export const RestBeforeAfterMiddleware = async (req: Request, res: Response, next: NextFunction) => {
    res.setHeader('Content-Type', 'application/json; charset=utf-8');
    res.setHeader('Access-Control-Allow-Origin', '*');
    res.setHeader('Access-Control-Allow-Methods', 'DELETE,GET,PATCH,POST,PUT');
    res.setHeader('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization');

    // 클라이언트 타입 체크
    if (isEmpty(req.headers['request-client-type']) === true) {
        clientErrorResponse(res, {
            error: '클라이언트 정보가 존재 하지 않습니다.'
        });
        return;
    }

    // accept 체크
    if (isEmpty(req.headers['accept']) === true) {
        clientErrorResponse(res, {
            error: '잘못된 요청 입니다.'
        });
        return;
    }

    // Content-type 체크
    if (isEmpty(req.headers['content-type']) === true) {
        clientErrorResponse(res, {
            error: '잘못된 요청 입니다.'
        });
        return;
    }

    next();
};
