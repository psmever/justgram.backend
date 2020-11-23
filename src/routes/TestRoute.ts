import * as express from "express";
import { getTest } from "src/controllers/TestController";

const TestRoute = express.Router();

// TestRoute.post('/admin/signup', verifyAuth, createAdmin);
TestRoute.get("/test", getTest);

export default TestRoute;
