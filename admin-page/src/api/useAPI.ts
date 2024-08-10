import { Theme, ThemeCreate } from "../models/Theme";
import ColorAPI from "./ColorAPI";
import ThemeAPI from "./ThemeAPI";

export default function useAPI() {
    const themesAPI = new ThemeAPI();
    const colorsAPI = new ColorAPI();

    function getThemes() {
        return themesAPI.getThemes();
    }
    
    function createTheme(theme: ThemeCreate) {
        return themesAPI.createTheme({ name: theme.name, description: theme.description, colorId: theme.color!.id });
    }
    
    function editTheme(theme: Theme) {
        return themesAPI.editTheme({ id: theme.id, name: theme.name, description: theme.description, colorId: theme.color!.id });
    }
    
    function deleteTheme(id: number) {
        return themesAPI.deleteTheme(id);
    }
    
    function getColors() {
        return colorsAPI.getColors();
    }

    return {
        getThemes,
        createTheme,
        editTheme,
        deleteTheme,

        getColors,
    };
}