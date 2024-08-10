import { Color } from "./Color";

export interface Theme {
    id: number;
    name: string;
    description: string;
    color: Color;
}

export interface ThemeCreate {
    name: string;
    description: string;
    color: Color;
}

export interface ThemeCreateDTO {
    name: string;
    description: string;
    colorId: number;
}

export interface ThemeEditDTO {
    id: number;
    name: string;
    description: string;
    colorId: number;
}