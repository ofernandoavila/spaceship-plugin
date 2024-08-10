import { Color } from "../../../models/Color";

interface IColorIcon {
    color: Color;
    onlySample?: boolean;
    displayValue?: boolean;
}

export default function ColorIcon({ color, onlySample = false, displayValue = false }: IColorIcon) {
    if(onlySample) {
        return (
            <div className="color-icon">
                <div className="color-sample" style={{ backgroundColor: `${ color.value }` }}></div>
            </div>
        );
    }
    return (
        <div className="color-icon">
            <div className="color-sample" style={{ backgroundColor: `${ color.value }` }}></div>
            <div className="color-description">{ displayValue ? color.value : color.description }</div>
        </div>
    );
}