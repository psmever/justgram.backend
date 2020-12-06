import { Request, Response, NextFunction } from 'express';
import { noCotentResponse, baseNoticeResponse, baseAppversionResponse, baseSuccessResponse, DeepMerge } from '@common';
import * as fs from 'fs';
import Codes from '@src/models/Codes';

// 기본 서버 상태 체크.
export const checkStatus = async (req: Request, res: Response, next: NextFunction): Promise<void> => {
    if (req) {
        noCotentResponse(res);
    }

    next();
};

// 서버 공지 사항 체크.
export const checkNotice = async (req: Request, res: Response): Promise<void> => {
    if (req) {
        fs.readFile('storage/server/notice.txt', 'utf8', function(err, notice) {
            if (err || notice === '') {
                noCotentResponse(res);
            } else {
                baseNoticeResponse(res, {
                    notice: notice.trim(),
                });
            }
        });
    }
};

// 앱 버전 체크.
export const appVersionCheck = async (req: Request, res: Response): Promise<void> => {
    if (req) {
        fs.readFile('storage/server/app_version.txt', 'utf8', function(err, appVersion) {
            if (err || appVersion === '') {
                noCotentResponse(res);
            } else {
                baseAppversionResponse(res, {
                    version: appVersion.trim(),
                });
            }
        });
    }
};

// 시스템 기본 데이터
export const baseData = async (req: Request, res: Response, next: NextFunction): Promise<void> => {
    const codeNameType = {};
    const codeGroupType = {};

    if (req) {
        await Codes.findAll({
            where: {
                active: 'Y',
            },
            attributes: ['id', 'group_id', 'code_id', 'group_name', 'code_name'],
        }).then(function(list) {
            list.filter(e => e.code_id != null).map(function(e) {
                const codeId = typeof e.code_id === 'string' ? e.code_id : '';
                const groupId = typeof e.group_id === 'string' ? e.group_id : '';
                const codeName = e.code_name;

                Object.assign(codeNameType, { [codeId]: codeName });

                DeepMerge(codeGroupType, { [groupId]: { [codeId]: codeName } });
            });

            baseSuccessResponse(res, {
                codes: {
                    code: codeNameType,
                    group: codeGroupType,
                },
            });
        });
    }

    next();
};
