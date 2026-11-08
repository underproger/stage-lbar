# Скачивает с сайта фото из списка photos.txt и пакует их в lbar-photos.zip (структура папок — от корня сайта).
# Вариант без доступа к хостингу: запускать в Windows, в папке, где лежат get-photos.ps1 и photos.txt:
#   powershell -ExecutionPolicy Bypass -File .\get-photos.ps1
#   powershell -ExecutionPolicy Bypass -File .\get-photos.ps1 -Site https://lbar.ro
param(
    [string]$Site = 'https://lbar.ro',
    [string]$List = (Join-Path $PSScriptRoot 'photos.txt')
)
$ErrorActionPreference = 'Stop'
$ProgressPreference = 'SilentlyContinue'
[Net.ServicePointManager]::SecurityProtocol = [Net.SecurityProtocolType]::Tls12
$dir = Join-Path $PSScriptRoot 'lbar-photos'
$zip = Join-Path $PSScriptRoot 'lbar-photos.zip'
if (Test-Path $dir) { Remove-Item $dir -Recurse -Force }
$ok = 0; $miss = @()
foreach ($line in Get-Content -LiteralPath $List -Encoding UTF8) {
    $f = $line.Trim()
    if ($f -eq '' -or $f.StartsWith('#')) { continue }
    $dst = Join-Path $dir ($f -replace '/', '\')
    New-Item -ItemType Directory -Force -Path (Split-Path $dst) | Out-Null
    $url = $Site.TrimEnd('/') + '/' + (($f.Split('/') | ForEach-Object { [uri]::EscapeDataString($_) }) -join '/')
    try {
        Invoke-WebRequest -Uri $url -OutFile $dst -UseBasicParsing -UserAgent 'Mozilla/5.0 lbar-photos'
        $ok++
    } catch {
        $miss += $f
        Write-Host "не скачалось: $f" -ForegroundColor Yellow
    }
}
if ($ok -eq 0) { Write-Host 'Ни одного файла не скачано.' -ForegroundColor Red; exit 1 }
if (Test-Path $zip) { Remove-Item $zip -Force }
Compress-Archive -Path (Join-Path $dir '*') -DestinationPath $zip
Write-Host "Готово: $zip — скачано $ok, не скачано $($miss.Count)" -ForegroundColor Green
