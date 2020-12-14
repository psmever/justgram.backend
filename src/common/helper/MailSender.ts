import nodemailer from 'nodemailer';
import { MailSenderSendEmailParm } from 'CommonTypes';

const MailSender = {
    // 메일발송 함수
    SendEmailAuth: function(param: MailSenderSendEmailParm): void {
        const transporter = nodemailer.createTransport({
            service: 'gmail',
            host: 'smtp.gmail.com',
            port: 587,
            secure: false,
            requireTLS: true,
            auth: {
                user: process.env.GMAIL_USERNAME,
                pass: process.env.GMAIL_PASSWORD,
            },
        });

        // 메일 옵션
        const mailOptions = {
            from: `"JustGram Team" <${process.env.GMAIL_USERNAME}>`,
            to: param.ToEmail, // 수신할 이메일
            subject: 'JustGram 이메일 인증을 해주세요.',
            text: param.EmailAuthCode,
            html: `<b>아래 링크를 클릭해서 이메일 인증을 완료해 주세요.</b><br /><br />
            <a href="${process.env.HOSTNAME}/web/emailauth/${param.EmailAuthCode}">클릭.</a>
            `,
        };
        // 메일 발송
        transporter.sendMail(mailOptions, function(error, info) {
            if (error) {
                console.log(error);
            } else {
                console.log('Email sent: ' + info.response);
            }
        });
    },
};

export default MailSender;
