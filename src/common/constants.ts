
const statusCode = {
	success: 200,
	error: 500,
	notfound: 404,
	unauthorized: 401,
	conflict: 409,
	created: 201,
	bad: 400,
	nocontent: 204,
};


const messages = {
	server: {
		test: "테스트 입니다.",
		notFoundNotice: "공지사항이."
	},
	response: {
		success: "정상 전송 하였습니다.",
	}
};

const serverPath = {
	storage: "src/storage"
};
export {
	statusCode,
	messages,
	serverPath
};