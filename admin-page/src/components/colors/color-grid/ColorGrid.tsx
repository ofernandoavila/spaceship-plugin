import ColorIcon from "../color-icon/ColorIcon";
import { IGlobalPropsOptions } from "../../themes/theme-form/ThemeForm";
import { Color } from "../../../models/Color";

interface IColorGridProps {
    colors: Color[];
    options?: IGlobalPropsOptions;
} 

export default function ColorGrid({ colors }: IColorGridProps) {
    return (
        <>
            { colors.length > 0 ? <table className="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Description</th>
                    <th scope="col">Value</th>
                </tr>
            </thead>
            <tbody>
                { colors.map( color => (
                    <tr>
                        <th scope="row">{ color.id }</th>
                        <td>{ color.description }</td>
                        <td><ColorIcon color={ color } displayValue/></td>
                    </tr>
                )) }
            </tbody>
        </table> : <h5>There is no data to show.</h5> }
        </>
    );
}