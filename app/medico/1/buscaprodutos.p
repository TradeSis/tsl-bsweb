/* medico na tela 042022 - helio */

def input  parameter vlcentrada as longchar.

{/admcom/progr/med/meddefs.i new}

def temp-table ttentrada no-undo serialize-name "dadosEntrada"
    field codigoFilial as char.


def var vlcsaida   as longchar.

def var vsaida as char.

def var lokjson as log.
def var hsaida   as handle.
def var hentrada   as handle.


FUNCTION acha2 returns character
    (input par-oque as char,
     input par-onde as char).
    def var vx as int.
    def var vret as char.
    vret = ?.
    do vx = 1 to num-entries(par-onde,"|").
        if num-entries( entry(vx,par-onde,"|"),"#") = 2 and
           entry(1,entry(vx,par-onde,"|"),"#") = par-oque
        then do:
            vret = entry(2,entry(vx,par-onde,"|"),"#").
            leave.
        end.
    end.
    return vret.
END FUNCTION.

hentrada = temp-table ttentrada:handle.
lokJSON = hEntrada:READ-JSON("longchar",vlcentrada, "EMPTY").

find first ttentrada no-error.

for each medprodu no-lock.
    find produ of medprodu no-lock.
    
    /* helio 24102022 */
    if medprodu.idmedico = "DOC24_ROBOX" then next.
    
    create ttmedprodu.
    ttmedprodu.procod     = produ.procod.
    ttmedprodu.pronom     = produ.pronom.
    run trata_caract_esp.p (input produ.pronom, output ttmedprodu.pronom).
    ttmedprodu.idmedico   = medprodu.idmedico.
    ttmedprodu.idPerfil   = medprodu.idPerfil.
    ttmedprodu.tipoServico   = medprodu.tipoServico.
    ttmedprodu.valorServico      = trim(string(medprodu.valorServico,">>>>>>>>>>>>>>>>>>>>>>9.99")).

    for each medperfil of medprodu where medperfil.pativo = yes no-lock.
        for each medpercampos of medperfil where medpercampos.cativo = yes no-lock
            by medpercampos.ordem.
            create ttcampos.
            ttcampos.IDPerfil = medperfil.idPerfil.
            ttcampos.idcampo  = medpercampos.idcampo.
            ttcampos.ID       = string(ttcampos.IDPerfil) + "-" + ttcampos.idcampo.
            ttcampos.nomecampo = medpercampos.nomecampo.
            ttcampos.ordem       = medpercampos.ordem.
            ttcampos.TIPO        = medpercampos.TIPO.
            ttcampos.OBRIGATORIEDADE = medpercampos.OBRIGATORIEDADE.
            ttcampos.MAXIMO      = medpercampos.MAXIMO.
            ttcampos.MINIMO      = medpercampos.MINIMO.
            ttcampos.VLRMAXIMO      = medpercampos.VLRMAXIMO.
            ttcampos.VLRMINIMO      = medpercampos.VLRMINIMO.
            ttcampos.PERIODO_MINIMO  = medpercampos.PERIODO_MINIMO.
            ttcampos.PERIODO_MAXIMO  = medpercampos.PERIODO_MAXIMO.
            for each medpercamopc of medpercampos no-lock.
                create ttopcoes.
                ttopcoes.idPAI = ttcampos.ID.
                ttopcoes.idcampo  = medpercampos.idcampo.
                ttopcoes.nomeOpcao = medpercamopc.nomeOpcao.
                ttopcoes.valorOpcao = medpercamopc.valorOpcao.
            end.
        end.
    end.
    for each medplan of medprodu no-lock.
        create ttplanos.
        ttplanos.procod = medplan.procod.
        ttplanos.fincod = medplan.fincod.
        find finan of medplan no-lock.
        ttplanos.qtdvezes = finan.finnpc.
        ttplanos.finnom = finan.finnom.
    end.
end.

hsaida  = dataset medicoSaida:handle.

/*lokJson = hsaida:WRITE-JSON("LONGCHAR", vlcSaida, TRUE).
message string(vlcsaida).*/


def var varquivo as char.
def var ppid as char.
INPUT THROUGH "echo $PPID".
DO ON ENDKEY UNDO, LEAVE:
IMPORT unformatted ppid.
END.
INPUT CLOSE.

varquivo  = "/u/bsweb/works/apimedicobuscaprodutos" + string(today,"999999") + replace(string(time,"HH:MM:SS"),":","") +
          trim(ppid) + ".json".

lokJson = hsaida:WRITE-JSON("FILE", varquivo, TRUE).

os-command value("cat " + varquivo).
os-command value("rm -f " + varquivo)

