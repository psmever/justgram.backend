// http 상태.
const httpStatus = {
    success: 200,
    error: 500,
    notfound: 404,
    unauthorized: 401,
    conflict: 409,
    created: 201,
    bad: 400,
    nocontent: 204,
};

// 결과 상태.
const responseStatus = {
    success: true,
    error: false,
};

const responseMessage = {
    error: {
        defaultClientError: '잘못된 요청 입니다.',
        clientTypeNotFound: '클라이언트 정보가 존재 하지 않습니다.',
        serverError: '처리중 문제가 발생 했습니다.',
    },
    default: {
        notfound: {
            usename: '사용자 이름을 입력해 주세요.',
            email: '이메일을 입력해 주세요.',
            password: '비밀 번호를 입력해 주세요.',
        },
        check: {
            email: '이미 사용중인 이메일 주소 입니다.',
            name: '이미 사용중인 사용자 이름 입니다.',
        },
    },
};

export { httpStatus, responseStatus, responseMessage };
