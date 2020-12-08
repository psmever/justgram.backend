/* eslint-disable @typescript-eslint/camelcase */
import { Request, Response, NextFunction } from 'express';
import { noCotentResponse, baseNoticeResponse, baseAppversionResponse, baseSuccessResponse, DeepMerge } from '@common';
import jwt from 'jsonwebtoken';

// 기본 서버 상태 체크.
export const login = async (req: Request, res: Response, next: NextFunction): Promise<void> => {
    const id = '1';
    const username = 'psmever   ';
    const payload = { id, username };

    jwt.sign(
        payload,
        'secret',
        {
            expiresIn: 3600,
        },
        (err, token) => {
            res.json({
                success: true,
                token: 'Bearer ' + token,
            });
        }
    );
};
