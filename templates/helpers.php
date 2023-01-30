<?php
/**
 * �������� �������� ���� �� ���������� ������� '����-��-��'
 *
 * �������� ������������:
 * isDateValid('2019-01-01'); // true
 * isDateValid('2016-02-29'); // true
 * isDateValid('2019-04-31'); // false
 * isDateValid('10.10.2010'); // false
 * isDateValid('10/10/2010'); // false
 *
 * @param string $date ���� � ������ �����
 *
 * @return bool true � ��� ���� � �������� '����-��-��', ������ false
 */
function isDateValid(string $date) : bool {
    $format_to_check = 'Y-m-d';
    $dateTimeObj = date_create_from_format($format_to_check, $date);

    return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
}

/**
 * ������� ������������ ����� �� ����� �������� SQL ������ � ��������� �����
 *
 * @param $link mysqli ������ �'�������
 * @param $sql string SQL ����� �� �������������� ������ �������
 * @param array $data ��� ��� ������� �� ���� ������������
 *
 * @return mysqli_stmt ϳ����������� �����
 */
function dbGetPrepareStmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = '�� ������� ������������ ������������ �����: ' . mysqli_error($link);
        throw new ErrorException($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = 's';

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = '�� ������� ���\'����� ������������ ����� �� �����������: ' . mysqli_error($link);
            throw new ErrorException($errorMsg);
        }
    }

    return $stmt;
}

/**
 * ������� �������� ����� �������
 * ���������: ����� ��� ����� �����
 *
 * ������� ������������:
 * $remainingMinutes = 5;
 * echo "� �������� ������ �� {$remainingMinutes} " .
 *     getNounPluralForm(
 *         $remainingMinutes,
 *         '�������',
 *         '�������',
 *         '������'
 *     );
 * ���������: "� �������� ������ �� 5 ������"
 *
 * @param int $number �����, �� ���� ���������� ����� �������
 * @param string $one ����� ������: ������, ������, �������
 * @param string $two ����� ������� ��� 2, 3, 4: ������, ������, �������
 * @param string $many ����� ������� ��� ����� �����
 *
 * @return string ����������� ����� �������
 */
function getNounPluralForm (int $number, string $one, string $two, string $many): string
{
    $number = (int) $number;
    $mod10 = $number % 10;
    $mod100 = $number % 100;

    switch (true) {
        case ($mod100 >= 11 && $mod100 <= 20):
            return $many;

        case ($mod10 > 5):
            return $many;

        case ($mod10 === 1):
            return $one;

        case ($mod10 >= 2 && $mod10 <= 4):
            return $two;

        default:
            return $many;
    }
}

/**
 * ϳ������ ������, ������ ���� ��� � ������� ���������� HTML �������
 *
 * @param string $name ���� �� ����� ������� ������� ����� templates
 * @param array $data ������������ ����� �� ������ ��� �������
 * @return string ϳ��������� HTML
 */
function renderTemplate($name, array $data = []) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}