import { UserModule } from "./user.model";

export interface Product {
    id?: number;

    name?: string;
    description?: string;
    status?: string;

    soort?: string;
    format?: object;

    hours?: Hours;
    deadline?: string;
    updated_at?: string;
    created_at?: string;

    attachment?: string;
    factuur?: string;
    kostenplaats?: string;
    referentie?: string;

    options?: ProductOptions;
    links?: object;

    owner?: UserModule;
    updated_by?: UserModule;
}

export interface ProductOptions {
    papier?: string;
    oplage?: string;
    afleveradres?: string;
    gewicht?: string;
}

export interface Hours {
    count?: number;
    total?: number;
    data?: Array<Product>;
}
