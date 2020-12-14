import { Request, Response, NextFunction } from 'express';
import { isEmpty, clientErrorResponse } from '@common';
import { responseMessage } from '@src/common/providers/ResponseMessage';
import { Users, UserProfiles, UserEmailAuth, UserType } from '@src/models';
import { sequelize } from '@src/instances/Sequelize';
import { v4 as uuidv4 } from 'uuid';
import MailSender from '@src/common/helper/MailSender';

// 로그인
export const login = async (req: Request, res: Response): Promise<void> => {
    console.log(req, res);
    // jwt.sign(
    //     payload,
    //     'secret',
    //     {
    //         expiresIn: 3600,
    //     },
    //     (err, token) => {
    //         res.json({
    //             success: true,
    //             token: 'Bearer ' + token,
    //         });
    //     }
    // );
};

// 회원 가입.
export const register = async (req: Request, res: Response, next: NextFunction): Promise<void> => {
    const { register_username, register_email, register_password } = req.body;

    // 사용자 이름.
    if (isEmpty(register_username)) {
        clientErrorResponse(res, {
            message: responseMessage.default.notfound.usename,
        });
        return;
    }

    // 사용자 이메일 없을경우.
    if (isEmpty(register_email)) {
        clientErrorResponse(res, {
            message: responseMessage.default.notfound.email,
        });
        return;
    }
    // 사용자 비밀번호가 없을경우.
    if (isEmpty(register_password)) {
        clientErrorResponse(res, {
            message: responseMessage.default.notfound.password,
        });
        return;
    }

    //이메일 중복 체크.
    const exitsEmail = await Users.findOne({
        where: {
            user_email: register_email,
        },
        attributes: ['id'],
    });

    if (isEmpty(exitsEmail) === false) {
        // 존재 하는 이메일.
        clientErrorResponse(res, {
            message: responseMessage.default.check.email,
        });
        return;
    }

    // 사용자 이름 중복 체크.
    const exitsName = await Users.findOne({
        where: {
            user_name: register_username,
        },
        attributes: ['id'],
    });

    if (isEmpty(exitsName) === false) {
        // 존재 하는 사용자 이름.
        clientErrorResponse(res, {
            message: responseMessage.default.check.name,
        });
        return;
    }

    const newUserUUID = uuidv4();
    const emailAuthCode = Array.from({ length: 70 }, () => Math.random().toString(36)[2]).join('');

    // 정상 입력.

    // 사용자 테이블 입력.
    const transaction = await sequelize.transaction();
    try {
        const task = await Users.create(
            {
                user_uuid: newUserUUID,
                user_email: register_email,
                user_name: register_username,
                user_password: register_password,
                user_level: 'A30000',
                active: 'N',
                profile_active: 'N',
            },
            { transaction }
        );

        await UserProfiles.create(
            {
                user_id: task.id,
            },
            { transaction }
        );

        await UserEmailAuth.create(
            {
                user_id: task.id,
                verify_code: emailAuthCode,
            },
            { transaction }
        );

        await UserType.create(
            {
                user_id: task.id,
                user_type: 'A20000',
            },
            { transaction }
        );

        MailSender.SendEmailAuth({
            ToEmail: register_email,
            EmailAuthCode: emailAuthCode,
        });

        await transaction.commit();
    } catch (err) {
        await transaction.rollback();
    }

    next();
};
