import { useEffect, useState } from "react";
import { Theme, ThemeCreate } from "../../../models/Theme";
import useModal from "../../global/modal/hooks/useModal";
import ColorPicker from "../color-picker/ColorPicker";
import useAPI from "../../../api/useAPI";
import { Color } from "../../../models/Color";

export interface IGlobalPropsOptions {
    onRefresh?: () => void;
}

interface IColorFormProps {
    color?: Color;
    options?: IGlobalPropsOptions;
}

export default function ColorForm({ color, options }: IColorFormProps) {
    const [data, setData] = useState<Color>({
        value: '',
        description: ''
    } as Color);
    const [erro, setErro] = useState<string | null>(null);

    useEffect(() => {
        if(color) {
            setData(color);
        } else {
            setData({
                value: '',
                description: ''
            } as Color);
        }
    }, [color]);

    const { HandleCloseModal } = useModal();
    const { createTheme, editTheme } = useAPI();

    const HandleSaveTheme = () => {
        Validate(data);

        if(erro) return;

        // createTheme(data as ThemeCreate)
        //     .then( res => {
        //         HandleCloseModal();
        //         if(options?.onRefresh) {
        //             options.onRefresh();
        //         }
        //     })
        //     .catch(error => setErro(error));
    };

    const HandleEditTheme = () => {
        Validate(data);

        if(erro) return;

        // editTheme(data as Color)
        //     .then( res => {
        //         HandleCloseModal();
        //         if(options?.onRefresh) {
        //             options.onRefresh();
        //         }
        //     })
        //     .catch(error => setErro(error));
    };
    
    const HandleCancelOperationTheme = () => {
        HandleCloseModal();
    };

    const Validate = (color: Color) => {
        if(color.value === '') setErro('The field value cannot be null');
        if(color.description === '') setErro('The field description cannot be null');
    }

    return (
        <div className="color-form">
            <h4>{ color ? 'Editing color' : 'Creating new color' }</h4>
            <div className="form-group">
                <label htmlFor="description" className="form-label">Description</label>
                <input type="text" className="form-control" name="description" id="description" placeholder="Describe your color..." value={data.description} onChange={ e => setData({ ...data, description: e.currentTarget.value }) } />
            </div>
            <div className="form-group">
                <label htmlFor="value" className="form-label">Value</label>
                <input type="text" className="form-control" name="value" id="value" placeholder="PHP, Typescript, SQL..." value={data.value} onChange={ e => setData({ ...data, value: e.currentTarget.value }) } />
            </div>
            { erro ? (
                <div className="form-group-errors">
                    <small className="text-danger">{ erro }</small>
                </div>
            ) : '' }
            <div className="form-group-btns">
                <button className="btn btn-default" onClick={HandleCancelOperationTheme}>Cancel</button>
                <button className="btn btn-primary" onClick={ color ? HandleEditTheme : HandleSaveTheme }>{ color ? 'Save changes' : 'Save color' }</button>
            </div>
        </div>
    );
}