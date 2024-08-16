import { Color } from "../models/Color";
import { Theme, ThemeCreateDTO, ThemeEditDTO } from "../models/Theme";
import APIClient from "./APIClient";

interface IAPIResponseMesage {
    msg: string;
}

class ColorAPI extends APIClient {
    getColors = () => this.get<Color[]>('/colors');
}

export default ColorAPI;