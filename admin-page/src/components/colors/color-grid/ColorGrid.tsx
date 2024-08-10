import useAPI from "../../../api/useAPI";
import { Theme } from "../../../models/Theme";
import ColorIcon from "../color-icon/ColorIcon";
import ConfirmDialog from "../../global/confirm-dialog/ConfirmDialog";
import useModal from "../../global/modal/hooks/useModal";
import { IGlobalPropsOptions } from "../../themes/theme-form/ThemeForm";
import ColorForm from "../color-form/ColorForm";
import { Color } from "../../../models/Color";

interface IColorGridProps {
    colors: Color[];
    options?: IGlobalPropsOptions;
} 

export default function ColorGrid({ colors, options }: IColorGridProps) {

    const { HandleOpenModal, HandleCloseModal } = useModal();

    const { deleteTheme } = useAPI();

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