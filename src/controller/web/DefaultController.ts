import { Request, Response } from 'express';

// 기본 서버 상태 체크.
export const index = async (req: Request, res: Response): Promise<void> => {
    res.render('index', { title: `${process.env.APP_NAME}`, env: process.env.SERVER_ENV });
};

export const emailauth = async (req: Request, res: Response): Promise<void> => {
    const {
        params: { authcode },
    } = req;
    console.log(authcode);
    // TODO : 2020-12-14 23:59 이메일 인증 처리.
    // http://localhost:3030/web/emailauth/zwg6yk1hpph8ysn18xvpyxhbg1qp9knpv46r8bq75pypces8d9eyn7vnvxsbyp49s0ygy9

    res.render('emailauth', { title: 'JustGram.Backend' });
};
