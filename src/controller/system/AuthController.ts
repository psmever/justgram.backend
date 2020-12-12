/* eslint-disable @typescript-eslint/camelcase */
import { Request, Response, NextFunction } from 'express';
import { noCotentResponse, baseNoticeResponse, baseAppversionResponse, baseSuccessResponse, DeepMerge } from '@common';
import jwt from 'jsonwebtoken';

// 로그인
export const login = async (req: Request, res: Response): Promise<void> => {
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

// 회원 가입.
export const register = async (req: Request, res: Response): Promise<void> => {
    console.log(req);

    res.json({
        controller: 'register',
    });
};
