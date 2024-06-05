import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import { forwardRef } from '@wordpress/element';
import { request } from "./request";

function Block ({ blockProps, attributes, setAttributes, isEditor = false }) {

    const [data, loading] = request(
        "/weberson/v1/data"
      );

    if ( ! loading ) {
        console.log(data);
        setAttributes({header: data[1][1].headers});
        setAttributes({body: data[1][1].rows });
    }
    
    return (
        <>
            <div { ...useBlockProps() }>

                    { loading ? (
                        "Loading preview..."
                    ) : (
                        <div class="weberson-block-section" >
                            <table class="form-table weberson-list-table">
                                <thead>
                                    <tr valign="top">
                                        {attributes.header && (
                                            attributes.header.map((th, index) => (
                                                <>
                                                    {attributes.showIdColumn && index === 0 && <th key={index} className={"item-" + index}>{th}</th>}
                                                    {attributes.showFirstNameColumn && index === 1 && <th key={index} className={"item-" + index}>{th}</th>}
                                                    {attributes.showLastNameColumn && index === 2 && <th key={index} className={"item-" + index}>{th}</th>}
                                                    {attributes.showEmailColumn && index === 3 && <th key={index} className={"item-" + index}>{th}</th>}
                                                    {attributes.showDateColumn && index === 4 && <th key={index} className={"item-" + index}>{th}</th>}
                                                </>
                                            ))
                                        )}
                                    </tr>
                                </thead>
                                <tbody>
                                    {attributes.body && (
                                        Object.keys(attributes.body).map((tr, index) => (
                                            <tr key={index}>
                                                {Object.values(attributes.body[tr]).map((td, index) => (
                                                    <>
                                                        {attributes.showIdColumn && index === 0 && <td key={index} className={"item-" + index}>{td}</td>}
                                                        {attributes.showFirstNameColumn && index === 1 && <td key={index} className={"item-" + index}>{td}</td>}
                                                        {attributes.showLastNameColumn && index === 2 && <td key={index} className={"item-" + index}>{td}</td>}
                                                        {attributes.showEmailColumn && index === 3 && <td key={index} className={"item-" + index}>{td}</td>}
                                                        {attributes.showDateColumn && index === 4 && <td key={index} className={"item-" + index}>{td}</td>}
                                                    </>
                                                ))}
                                            </tr>
                                        ))
                                    )}
                                </tbody>
                                

                            </table>
                        </div>
                    )}

            </div>
        </>
    );
}

export default forwardRef( Block );
