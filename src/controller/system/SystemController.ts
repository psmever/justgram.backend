import { Request, Response, NextFunction } from 'express';
import {
    sample,
    CodesList,
    noCotentResponse,
    baseNoticeResponse,
    baseAppversionResponse,
    baseSuccessResponse,
} from '@common';
import * as fs from 'fs';

// 기본 서버 상태 체크.
export const checkStatus = async (req: Request, res: Response, next: NextFunction) => {
    noCotentResponse(res);
    next();
};

// 서버 공지 사항 체크.
export const checkNotice = async (req: Request, res: Response, next: NextFunction) => {
    fs.readFile('storage/server/notice.txt', 'utf8', function(err, notice) {
        if (err || notice === '') {
            noCotentResponse(res);
        } else {
            baseNoticeResponse(res, {
                notice: notice.trim(),
            });
        }
    });
};

// 앱 버전 체크.
export const appVersionCheck = async (req: Request, res: Response, next: NextFunction) => {
    fs.readFile('storage/server/app_version.txt', 'utf8', function(err, appVersion) {
        if (err || appVersion === '') {
            noCotentResponse(res);
        } else {
            baseAppversionResponse(res, {
                version: appVersion.trim(),
            });
        }
    });
};

// 시스템 기본 데이터
export const baseData = async (req: Request, res: Response, next: NextFunction) => {
    baseSuccessResponse(res, CodesList);
};
