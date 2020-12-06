import { Request, Response, NextFunction } from 'express';
import Codes from '@src/models/Codes';
import { baseSuccessResponse } from '@common';

// 기본 테스트.
export const Default = async (req: Request, res: Response, next: NextFunction): Promise<void> => {
    const instance = await Codes.findByPk(1, {
        rejectOnEmpty: true,
    });

    baseSuccessResponse(res, instance);

    next();
};
