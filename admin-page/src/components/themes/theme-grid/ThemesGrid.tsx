import useAPI from "../../../api/useAPI";
import { Theme } from "../../../models/Theme";
import ColorIcon from "../../colors/color-icon/ColorIcon";
import ConfirmDialog from "../../global/confirm-dialog/ConfirmDialog";
import useModal from "../../global/modal/hooks/useModal";
import ThemeForm, { IGlobalPropsOptions } from "../theme-form/ThemeForm";

interface IThemesGridProps {
    themes: Theme[];
    options?: IGlobalPropsOptions;
} 

export default function ThemesGrid({ themes, options }: IThemesGridProps) {

    const { HandleOpenModal, HandleCloseModal } = useModal();

    const { deleteTheme } = useAPI();

    const HandleDeleteTheme = (theme: Theme) => {
        deleteTheme(theme.id)
            .then(() => {
                HandleCloseModal();

                if(options?.onRefresh) {
                    options.onRefresh();
                }
            });
    }

    return (
        <>
            { themes.length > 0 ? <table className="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Color</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                { themes.map( theme => (
                    <tr>
                        <th scope="row">{ theme.id }</th>
                        <td>{ theme.name }</td>
                        <td>{ theme.description }</td>
                        <td><ColorIcon color={ theme.color } /></td>
                        <td style={{ display: 'flex', alignItems: 'center', gap: 8 }}>
                            <span onClick={ e => HandleOpenModal(<ThemeForm theme={ theme } options={options} />) }>Edit</span>
                            <span onClick={ e => HandleOpenModal(<ConfirmDialog title="Tem certeza de que deseja exluir?" onConfirm={ () => HandleDeleteTheme(theme) } btnConfirmLabel="Delete theme" />) }>Delete</span>
                        </td>
                    </tr>
                )) }
            </tbody>
        </table> : <h5>There is no data to show.</h5> }
        </>
    );
}