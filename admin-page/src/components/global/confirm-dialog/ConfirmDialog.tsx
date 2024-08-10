import useModal from "../modal/hooks/useModal";
import './_confirm-dialog.scss';

interface IConfirmDialogProps {
    title: string;
    onConfirm: () => void;
    btnConfirmLabel?: string;
}

export default function ConfirmDialog({ title, onConfirm, btnConfirmLabel }: IConfirmDialogProps) {

    const { HandleCloseModal } = useModal();

    return (
        <div className="confirm-dialog">
            <h4>{ title }</h4>
            <div className="form-group-btns">
                <button className="btn btn-default" onClick={ HandleCloseModal }>Cancel</button>
                <button className="btn btn-primary" onClick={ onConfirm }>{ btnConfirmLabel ?? 'Save theme' }</button>
            </div>
        </div>
    );
}