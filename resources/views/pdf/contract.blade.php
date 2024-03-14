<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Contrato de Locação</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="{{ base_path('public/css/pdf.css') }}">
</head>

<body>
    <table id="header">
        <tr>
            <td></td>
            <td id="title">Contrato de Locação</td>
            <td id="contract-number-wrapper">
                No. <div id="contract-number">{{ $rent->id }}/{{ $rent->starting_date->format('Y') }}</div>
            </td>
        </tr>
    </table>
    <br />
    <p>
        <u>CONTRATO DE LOCAÇÃO</u>, que entre si fazem, <u>VIGO ANDAIMES LTDA.</u>, inscrita no CNPJ sob o n.º 12.054.221/0001-21, com sede na Capital do Estado do Rio de Janeiro, à Rua Paul Underberg, nº 50, esquina com Rua Conde de Bonfim nº 1.136 – Tijuca – Rio de Janeiro, doravante denominada <u>LOCADORA</u> e {{ Str::upper($rent->contact_name) }}, endereço: {{ $rent->contact_address }}, tel.: {{ $rent->contact_main_phone }}, {{ Str::length($rent->contact_document_number) === 14 ? 'CPF' : 'CNPJ' }}: {{ $rent->contact_document_number }}, doravante denominado <u>LOCATÁRIO</u>, na melhor forma de direito conforme cláusulas e condições seguintes:
    </p>
    <br />
    <p>
        1ª) O objeto deste contrato é a LOCAÇÃO de ANDAIMES e/ou equipamentos nas quantidades, especificações e valores abaixo discriminados:
    </p>
    <table id="products-table">
        <tr>
            <th>QUANTIDADE</th>
            <th id="products-name-column">DISCRIMINAÇÃO</th>
            <th>VALOR</th>
        </tr>
        @foreach ($products as $product)
        <tr>
            <td style="text-align: center;">01</td>
            <td style="padding-left: 4px;">{{ $product->type->name }}</td>
            <td style="text-align: center;">R$ {{ formatMoney($product->pivot->price) }}</td>
        </tr>
        @endforeach
    </table>
    <p>
        Obs.: 1) Serviço de entrega e retirada: R$ {{ formatMoney($rent->shipping_fee) }}.<br />
        Obs.: 2) O I.S.S. será cobrado separadamente conforme legislação em vigor;<br />
        2ª) Os preços acima fixados são válidos para o mês de início da locação. O reajuste de preços observará o disposto na legislação vigente;<br />
        3ª) Este contrato será válido por 30 dias, iniciando-se na data de emissão da primeira nota fiscal de entrega do(s) equipamento(s);<br />
        4ª) O local de uso do(s) equipamento(s) objeto deste contrato pelo locatário será: {{ $rent->usage_address }}, sendo vedada expressamente à transferência de local sob pena de retomada, pela Locadora, do(s) equipamento(s) independente de comunicação prévia;<br />
        5ª) A transferência do(s) equipamento(s) sem prévia autorização da Locadora caracteriza o crime de “Apropriação Indébita”, estando o infrator sujeito às penas da Lei;<br />
        6ª) A montagem e desmontagem do(s) equipamento(s) serão executados pela(o) Locatária (o), podendo este solicitar a assistência técnica de pessoal da Locadora que, por sua vez, se compromete a fazê-lo mediante o pagamento da taxa de assistência técnica vigente à época da solicitação;<br />
        7ª) Os aluguéis serão pagos mensalmente a partir da data de emissão da nota fiscal de entrega do(s) equipamento(s) até a data de devolução do(s) equipamento(s) ao nosso depósito, fato este caracterizado pela emissão da nota fiscal de devolução, que deverá ser emitida pelo locatário e, na falta deste, pela Nota Fiscal de Entrada emitida pela Locadora;<br />
        8ª) O pagamento dos aluguéis será feito no escritório da Locadora ou onde esta indicar. A Locadora emitirá, mensalmente fatura e duplicata de prestação de serviço que o Locatário aceita, desde já, como dívida líquida e certa, exigível no seu vencimento;<br />
        9ª) O não pagamento de qualquer obrigação no seu vencimento, sujeita o Locatário ao pagamento de juros e, no caso de atraso superior a 5 (cinco) dias, multa contratual no valor de 20% sobre o valor atualizado da obrigação, sem prejuízo da rescisão do Contrato que poderá ser exigido pela Locadora;<br />
        10ª) O prazo mínimo de locação será de 30 (trinta) dias;<br />
        11ª) É facultado ao Locatário a devolução do(s) equipamento(s) antes do prazo contratual estabelecido na Cláusula 3ª, ciente de que lhe será cobrado o aluguel mínimo de 30 (trinta) dias;<br />
        12ª) Caso haja interesse em renovação deste contrato, fica acertado que a Locadora poderá, a seu exclusivo critério e decisão, renová-lo desde que obedecidas as suas especificações:<br />
    <div style="margin-left: 24px; margin-top: -12px;">
        12.1) Comunicação do Locatário por escrito com antecedência mínima de 30 (trinta) dias;<br />
    </div>
    <div style="margin-left: 24px; ">
        12.2) Reajuste do preço básico estabelecido na Cláusula 1ª para os níveis vigentes da Locadora à época de renovação;<br />
    </div>
    <div style="margin-left: 24px; ">
        12.3) Seja feito um novo contrato idêntico a este;<br />
    </div>
    13ª) Não havendo comunicação do Locatário, fica a Locadora autorizada a retirar o(s) equipamento(s) ao término deste contrato;<br />
    14ª) Havendo interesse do Locatário na locação de mais equipamentos será feito um contrato de locação aditivo a este contrato, com as mesmas características e local de uso descritos, respectivamente nas Cláusulas 1ª e 4ª. A Locadora se reserva ao direito de reajustar os preços de locação, de forma a nivelar aos vigentes na Locadora, fato este que não ocorrerá se o Locatário solicitar o citado contrato aditivo antes de transcorridos 30 (trinta) dias da emissão da primeira Nota Fiscal de entrega do(s) equipamento(s) objeto(s) deste contrato;<br />
    15ª) O transporte do(s) equipamento(s) objeto(s) deste contrato tanto do depósito da Locadora para o local de utilização descrito na Cláusula 4ª como de retorno ocorrerá por conta do Locatário, que deverá também fornecer pessoal para carga e descarga. A Locadora cobrará este serviço separadamente;<br />
    16ª) A Locadora poderá disponibilizar o serviço de transporte do(s) equipamento(s) que será cobrado separadamente;<br />
    17ª) A entrega e devolução do(s) equipamento(s) da Locadora serão caracterizados por Notas Fiscais devidamente assinadas pelo preposto do Locatário;<br />
    18ª) O Locatário, ao receber a Nota Fiscal de entrega do(s) equipamento(s), declara ter recebido os mesmos em perfeito estado de conservação e uso, se comprometendo a manter, conservar e devolvê-los tais como recebidos de forma a permitir sua imediata utilização sem necessidade de reparos e/ou substituição de peças;<br />
    19ª) O(s) equipamento(s) será(ão) inspecionado(s) periodicamente pela Locadora que, caso constate a necessidade de retirada de algum equipamento para manutenção em seu depósito, avisará imediatamente ao Locatário, que por sua vez, se obriga a paralisar imediatamente a utilização do(s) equipamento(s) a ser(em) revisado(s);<br />
    20ª) Caso a Locadora constate eventual dano(s) no(s) equipamento(s) por mau uso, imperícia, relaxamento, ou qualquer outro motivo, esta se reserva o direito da cobrar na fatura os serviços necessários à reparação do(s) dano(s) verificado(s);<br />
    21ª) O(s) equipamento(s) que for(em) devolvido(s) apresentando dano, avaria e/ou qualquer outro defeito, assim como qualquer evidência de perda de eficiência ou segurança que não permitam sua imediata utilização, mesmo que proveniente de corrosão em virtude de sua utilização em local ou ambiente, que possa acelerar o seu desgaste, por força maior ou culpa de terceiros, caso fortuito, será a Locadora indenizada pelo Locatário. A Locadora fica autorizada a sacar contra o Locatário Nota de débito a título de indenização a ser paga no prazo máximo de 10 (dez) dias, obrigando-se o Locatário a aceitar desde já, reconhecendo como líquido e certo e exigível. O Locatário se obriga a devolver todos os bens que lhe forem entregues, ciente de que a retenção constituí ilícito penal e cível;<br />
    22ª) O valor da indenização de que trata a Cláusula anterior será determinado exclusivamente pela Tabela de Indenização que se anexa a este contrato;<br />
    23ª) O não pagamento da Nota de Débito inserida na Cláusula 21ª acarretará nas mesmas penalidades estabelecidas na Cláusula 9ª;<br />
    24ª) O Locatário declara conhecer a necessidade do uso de equipamento de proteção por funcionários que trabalhem com andaimes e estes equipamentos de proteção e segurança são de sua inteira responsabilidade. Fica aqui caracterizado no ato da assinatura deste contrato o oferecimento dos equipamentos de segurança, conforme estipulação legal, ressaltando-se que, este equipamento de segurança será cobrado separadamente;<br />
    25ª) Caso a Locadora constate, em suas inspeções periódicas, a utilização do(s) equipamento(s) em condições impróprias, que envolvam inadequada conservação ou uso, conflitante com as normas de Segurança do Trabalho, do Ministério do Trabalho e Previdência Social (Portaria 3214 de 08/06/78, NR 18 do Ministério do Trabalho – DOU de 11/07/83) ou recomendações da Associação Brasileira de Normas Técnicas (NB – 56), as quais o Locatário declara conhecer, que possam por em risco a integridade dos operários e/ou terceiros, ou que ameacem danificar o(s) equipamento(s), poderá considerar rescindido o Contrato;<br />
    26ª) Ocorrendo qualquer acidente com o(s) equipamento(s) ou em função de seu uso, durante a vigência deste contrato, desde a entrega até a devolução do(s) equipamento(s), estes serão de inteira responsabilidade do Locatário, que assume todas as obrigações decorrentes, isentando a Locadora de quaisquer responsabilidades sejam civis, penais e/ou trabalhistas;<br />
    27ª) O Locatário autoriza a Locadora a colocar placa identificativa no local de uso do(s) equipamento(s);<br />
    28ª) Qualquer comunicação do Locatário a Locadora, relativa a este Contrato será efetivada por escrito. Os avisos e comunicações verbais, acaso aceitos não representam novação ou revogação de existência de comunicação escrita;<br />
    29ª) Findo ou rescindido o presente contrato, a Locadora se reserva o direito de retirar todo(s) o(s) equipamento(s) do local em que estiverem independente de aviso prévio, interpelação judicial ou extra-judicial;<br />
    30ª) O presente Contrato poderá ser rescindido em virtude da infração de qualquer de suas cláusulas ou por falência, insolvência ou concordata do Locatário;<br />
    31ª) Na qualidade de interveniente e coobrigado solidariamente responsável por todas as obrigações assumidas pelo Locatário por força deste contrato apresenta-se:
    ___________________________________________________________________________<br />
    Tel.: _______________________ CPF: ______________________<br />
    32ª) Fica eleito o Foro da Cidade do Rio de Janeiro para dirimir qualquer dúvida que acaso ocorra na interpretação ou execução deste contrato com renúncia a qualquer outro, por mais privilegiado que possa ser. E por estarem assim justos e contratados, assinam o presente em 2 (duas) vias de igual teor, juntamente com as testemunhas abaixo:
    </p>
    <br />
    <br />
    <div id="signatures">
        <div id="signatures-date">
            Rio de Janeiro, {{ $rent->starting_date->locale('pt_BR')->isoFormat('LL') }}
        </div>
        <br />
        <br />
        <br />
        <span id="signatures-line">____________________________________________</span><br />
        <span id="signatures-name">VIGO ANDAIMES
        </span>
        <br />
        <br />
        <br />
        <span id="signatures-line">____________________________________________</span><br />
        <span id="signatures-name">
            {{ Str::upper($rent->contact_name) }}<br />
            {{ Str::length($rent->contact_document_number) === 14 ? 'CPF' : 'CNPJ' }}: {{ $rent->contact_document_number }}
        </span>
    </div>
</body>
