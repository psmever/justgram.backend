import { Response } from 'express';
import { AppHttpResponsePayload, ServerNoticeResponsePayload, ServerAppversionResponsePayload } from 'CommonTypes';

// 클라이언트 에러.
export function clientErrorResponse(response: Response, payload: AppHttpResponsePayload): Response {
    return response.status(412).json({
        status: false,
        payload,
    });
}

// 기본 내용없음.
export function noCotentResponse(response: Response): Response {
    return response.status(204).json();
}

// 기본 성공.
export function baseSuccessResponse(response: Response, payload: any): Response {
    return response.status(200).json({
        status: true,
        payload,
    });
}

// 서버 공지사항.
export function baseNoticeResponse(response: Response, payload: ServerNoticeResponsePayload): Response {
    return response.status(200).json(payload);
}

// 앱 버전.
export function baseAppversionResponse(response: Response, payload: ServerAppversionResponsePayload): Response {
    return response.status(200).json(payload);
}
