import { Response } from 'express';

export interface AppHttpResponse {
    error: string;
    message: string;
}

export function ClientErrorResponse(response: Response, body: AppHttpResponse): Response {
    return response.status(400).json(body);
}
