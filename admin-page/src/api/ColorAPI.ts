import { Color } from "../models/Color";
import { Theme, ThemeCreateDTO, ThemeEditDTO } from "../models/Theme";

interface IAPIResponseMesage {
    msg: string;
}

class ColorAPI {
    private __baseURL: string;

    constructor() {
        this.__baseURL = process.env.REACT_APP_BASE_URL! + process.env.REACT_APP_SPACESHIP_URL!;
    }

    getColors = () => new Promise<Color[]>((resolve, reject) => {
        fetch(this.__baseURL + '/colors', {
            method: 'GET'
        }).then( res => res.json())
            .then( data => resolve(data as Color[]))
            .catch( error => reject(error) );
    });
    
    createTheme = (theme: ThemeCreateDTO) => new Promise<Theme>((resolve, reject) => {
        fetch(this.__baseURL + '/themes', {
            method: 'POST',
            body: JSON.stringify(theme)
        }).then( res => res.json())
            .then( data => resolve(data as Theme))
            .catch( error => reject(error) );
    });
    
    editTheme = (theme: ThemeEditDTO) => new Promise<IAPIResponseMesage>((resolve, reject) => {
        fetch(this.__baseURL + '/themes', {
            method: 'PATCH',
            body: JSON.stringify(theme)
        }).then( res => res.json())
            .then( data => resolve(data as IAPIResponseMesage))
            .catch( error => reject(error) );
    });

    deleteTheme = (id: number) => new Promise<IAPIResponseMesage>((resolve, reject) => {
        fetch(this.__baseURL + '/themes/' + id.toString(), {
            method: 'DELETE'
        }).then( res => res.json())
            .then( data => resolve(data as IAPIResponseMesage))
            .catch( error => reject(error) );
    });
}

export default ColorAPI;