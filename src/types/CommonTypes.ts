declare module 'CommonTypes' {
    // 기본 에러
    export interface AppHttpResponsePayload {
        error: string;
    }

    // 서버 공치 사항
    export interface ServerNoticeResponsePayload {
        notice: string;
    }

    // 앱 버전 체크.
    export interface ServerAppversionResponsePayload {
        version: string;
    }
}
