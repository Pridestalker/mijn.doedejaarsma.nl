import { Product } from "./product.model";

export interface UserModule {
    id?: number;
    name?: string;

    email?: string;

    team?: object;
    role?: object;
    permission?: object;

    projects?: Array<Product>;
    requests?: Array<Request>;
}

export interface Request {
    count?: number;
    data?: Array<Product>;
}
