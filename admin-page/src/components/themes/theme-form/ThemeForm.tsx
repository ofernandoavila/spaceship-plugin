import { useEffect, useState } from "react";
import { Theme, ThemeCreate } from "../../../models/Theme";
import useModal from "../../global/modal/hooks/useModal";
import ColorPicker from "../../colors/color-picker/ColorPicker";
import useAPI from "../../../api/useAPI";
import { Color } from "../../../models/Color";

export interface IGlobalPropsOptions {
    onRefresh?: () => void;
}

interface IThemeFormProps {
    theme?: Theme;
    options?: IGlobalPropsOptions;
}

export default function ThemeForm({ theme, options }: IThemeFormProps) {
    const [data, setData] = useState<ThemeCreate | Theme>({
        name: '',
        description: '',
        color: {} as Color
    } as ThemeCreate);
    const [erro, setErro] = useState<string | null>(null);

    useEffect(() => {
        if(theme) {
            setData(theme);
        } else {
            setData({
                name: '',
                description: '',
                color: {} as Color
            });
        }
    }, [theme]);

    const { HandleCloseModal } = useModal();
    const { createTheme, editTheme } = useAPI();

    const HandleSaveTheme = () => {
        Validate(data);

        if(erro) return;

        createTheme(data as ThemeCreate)
            .then( res => {
                HandleCloseModal();
                if(options?.onRefresh) {
                    options.onRefresh();
                }
            })
            .catch(error => setErro(error));
    };

    const HandleEditTheme = () => {
        Validate(data);

        if(erro) return;

        editTheme(data as Theme)
            .then( res => {
                HandleCloseModal();
                if(options?.onRefresh) {
                    options.onRefresh();
                }
            })
            .catch(error => setErro(error));
    };
    
    const HandleCancelOperationTheme = () => {
        HandleCloseModal();
    };

    const Validate = (theme: ThemeCreate) => {
        if(theme.name === '') setErro('The field name cannot be null');
        if(theme.description === '') setErro('The field description cannot be null');
        if(theme.color === undefined) setErro('The field color cannot be null');
    }

    return (
        <div className="theme-form">
            <h4>{ theme ? 'Editing theme' : 'Creating new theme' }</h4>
            <div className="form-group">
                <label htmlFor="name" className="form-label">Name</label>
                <input type="text" className="form-control" name="name" id="name" placeholder="PHP, Typescript, SQL..." value={data.name} onChange={ e => setData({ ...data, name: e.currentTarget.value }) } />
            </div>
            <div className="form-group">
                <label htmlFor="description" className="form-label">Description</label>
                <input type="text" className="form-control" name="description" id="description" placeholder="Describe your theme..." value={data.description} onChange={ e => setData({ ...data, description: e.currentTarget.value }) } />
            </div>
            <div className="form-group">
                <label htmlFor="" style={{ marginBottom: '.5rem' }}>Color</label>
                <ColorPicker value={ data.color } setValue={ e => setData({ ...data, color: e }) } />
            </div>
            { erro ? (
                <div className="form-group-errors">
                    <small className="text-danger">{ erro }</small>
                </div>
            ) : '' }
            <div className="form-group-btns">
                <button className="btn btn-default" onClick={HandleCancelOperationTheme}>Cancel</button>
                <button className="btn btn-primary" onClick={ theme ? HandleEditTheme : HandleSaveTheme }>{ theme ? 'Save changes' : 'Save theme' }</button>
            </div>
        </div>
    );
}