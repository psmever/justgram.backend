import { Response } from 'express';
import { httpStatus, responseStatus, responseMessage } from '@src/common/providers/ResponseMessage';
import { AppHttpResponseErrorMessage, ServerNoticeResponsePayload, ServerAppversionResponsePayload } from 'CommonTypes';

// 기본 내용없음.
export function noCotentResponse(response: Response): Response {
    return response.status(httpStatus.nocontent).json();
}

// 서버 공지사항.
export function baseNoticeResponse(response: Response, payload: ServerNoticeResponsePayload): Response {
    return response.status(httpStatus.success).json(payload);
}

// 앱 버전.
export function baseAppversionResponse(response: Response, payload: ServerAppversionResponsePayload): Response {
    return response.status(httpStatus.success).json(payload);
}

// 서버 에러.
export function serverErrorResponse(response: Response): Response {
    return response
        .status(httpStatus.error)
        .json({ status: responseStatus.error, message: responseMessage.error.serverError });
}

// 클라이언트 에러.
export function clientErrorResponse(response: Response, message: AppHttpResponseErrorMessage): Response {
    return response.status(httpStatus.bad).json({
        status: responseStatus.error,
        ...message,
    });
}

// 기본 성공.
export function baseSuccessResponse<T>(response: Response, payload: T): Response {
    return response.status(httpStatus.success).json({
        status: responseStatus.success,
        ...payload,
    });
}
