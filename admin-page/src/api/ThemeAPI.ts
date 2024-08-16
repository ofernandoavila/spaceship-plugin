import { Theme, ThemeCreateDTO, ThemeEditDTO } from "../models/Theme";
import APIClient from "./APIClient";

interface IAPIResponseMesage {
    msg: string;
}

class ThemeAPI extends APIClient {
    getThemes = () => this.get<Theme[]>('/themes');
    createTheme = (theme: ThemeCreateDTO) => this.post<Theme>('/themes', theme);
    editTheme = (theme: ThemeEditDTO) => this.patch<IAPIResponseMesage>('/themes', theme);
    deleteTheme = (id: number) => this.delete<IAPIResponseMesage>(`/themes/${id}`);
}

export default ThemeAPI;