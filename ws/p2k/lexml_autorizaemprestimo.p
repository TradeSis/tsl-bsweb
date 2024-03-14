
def input parameter p-arquivo as char.

def var vtabela as char.
def var Hdoc    as handle.
def var Hroot   as handle.

create x-document HDoc.
Hdoc:load("file",p-arquivo,false).
create x-noderef hroot.
hDoc:get-document-element(hroot).

def shared temp-table parcelas 
    field seq_parcela as char
    field vlr_parcela as char
    field venc_parcela as char
    field numero_contrato as char.

def shared temp-table AutorizarEmprestimo
    field codigo_filial     as char
    field codigo_operador   as char
    field numero_pdv        as char
    field codigo_cliente    as char
    field codigo_produto    as char
    field valor_tfc         as char
    field valor_credito     as char
    field nsu_venda         as char
    field vendedor          as char
    field codigo_seguro_prestamista as char
    field valor_seguro_prestamista  as char.

def var vseq_parcela  as char.
def var vvlr_parcela  as char.
def var vvenc_parcela as char.
    
create AutorizarEmprestimo.

run obtemnode (input hroot).


procedure obtemnode.
    
    def input parameter vh as handle.
    def var hc as handle.
    def var loop  as int.
            
    create x-noderef hc.
                   
    do loop = 1 to vh:num-children.
    
        vh:get-child(hc,loop).
    
        if hc:subtype = "Element"
        then do:
            if vh:name = "AutorizarEmprestimo"
            then vtabela = "AutorizarEmprestimo".
            if vh:name = "parcelas"
            then vtabela = "Parcelas".
        end.
    
        if hc:subtype = "text"
        then do:
            if vtabela = "AutorizarEmprestimo"
            then do:
                case vh:name:
                when "codigo_filial"   then 
                        AutorizarEmprestimo.codigo_filial = hc:node-value.
                when "codigo_operador" then
                        AutorizarEmprestimo.codigo_operador = hc:node-value.
                when "numero_pdv"      then
                        AutorizarEmprestimo.numero_pdv = hc:node-value.
                when "codigo_cliente"  then
                        AutorizarEmprestimo.codigo_cliente = hc:node-value.
                when "codigo_produto"  then
                        AutorizarEmprestimo.codigo_produto = hc:node-value.
                when "valor_tfc"       then 
                        AutorizarEmprestimo.valor_tfc = hc:node-value.
                when "valor_credito"   then 
                        AutorizarEmprestimo.valor_credito = hc:node-value.
                when "nsu_venda"       then
                        AutorizarEmprestimo.nsu_venda = hc:node-value.
                when "vendedor"        then
                        AutorizarEmprestimo.vendedor = hc:node-value.
                when "codigo_seguro_prestamista" then
                 AutorizarEmprestimo.codigo_seguro_prestamista = hc:node-value.
                when "valor_seguro_prestamista" then
                 AutorizarEmprestimo.valor_seguro_prestamista = hc:node-value.
                end case.
             end.
            if vtabela = "parcelas"
            then do: 
                case vh:name:
                when "seq_parcela" then vseq_parcela = hc:node-value. 
                when "vlr_parcela" then vvlr_parcela = hc:node-value. 
                when "data_vencimento"
                then do:
                    vvenc_parcela = hc:node-value.
                    create parcelas.
                    parcelas.seq_parcela     = vseq_parcela.         
                    parcelas.vlr_parcela     = vvlr_parcela.
                    parcelas.venc_parcela    = vvenc_parcela.
                end.                    
                end case.
            end.
        end.

        run obtemnode (input hc:handle).
    end.
    
end procedure.